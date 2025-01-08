<?php

namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Manifiesto;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Enviar paquetes';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id = 0;
    public $date_ini;
    public $date_traslado;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id = 1;
    public $vehiculo_id = 1;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $caja;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }

        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d H:i');
        //Ids sucursales activos por sucursal segun configuracion
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');
        //Sucursales activas segun configuracion
        if (!$this->caja or $p->isEmpty()) {
            $this->redirectRoute('caja.index');
        } else {
            $this->sucursal_dest_id = Sucursal::where('isActive', true)
                ->whereIn('id', $p)
                ->first()
                ->id;
        }
    }
    public function render()
    {
        //Ids sucursales activos por sucursal segun configuracion
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');
        //Sucursales activas segun configuracion
        $sucursals = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->get();

        //Transportista y vehiculo segun configuracion
        $this->transportista_id = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_destino_id', $this->sucursal_dest_id)
            ->first()
            ->transportista_id;
        $this->vehiculo_id = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_destino_id', $this->sucursal_dest_id)
            ->first()
            ->vehiculo_id;

        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('isActive', $this->isActive)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_dest_id', $this->sucursal_dest_id)
            ->where('estado_encomienda', 'REGISTRADO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%'))
            ->latest()
            ->paginate($this->perPage, '*', 'page');

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        return view('livewire.package.send-package-live', compact('encomiendas', 'sucursals', 'transportistas', 'vehiculos'));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_dest = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->modalEnvio = !$this->modalEnvio;
        } else {
            $this->error('Seleccione al menos un paquete!');
        }
    }
    public function sendPaquetes()
    {
        if (!is_null($this->vehiculo_id) and !is_null($this->transportista_id)) {

            $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->update([
                'estado_encomienda' => 'ENVIADO',
                'updated_at' => $this->date_traslado,
                'vehiculo_id' => $this->vehiculo_id,
                'transportista_id' => $this->transportista_id,
            ]);
            if (count($this->selected) == $num_encomiendas_enviadas) {
                $this->success('Genial, ingresado correctamente!');
                $this->modalEnvio = false;
                $ids = $this->selected;
                $this->selected = [];
                Manifiesto::create([
                    'sucursal_id' => Auth::user()->sucursal->id,
                    'sucursal_destino_id' => $this->sucursal_dest_id,
                    'ids' => json_encode($ids),
                ]);
                SucursalConfiguration::where('sucursal_id', Auth::user()->sucursal->id)
                    ->where('sucursal_destino_id', $this->sucursal_dest_id)
                    ->update([
                        'isActive' => false,
                    ]);
                $p = SucursalConfiguration::where('isActive', true)
                    ->where('sucursal_id', Auth::user()->sucursal->id)
                    ->pluck('sucursal_destino_id');
                //Sucursales activas segun configuracion
                $sucursals = Sucursal::where('isActive', true)
                    ->whereIn('id', $p)
                    ->get();
                //Sucursal destino
                $this->sucursal_dest_id = Sucursal::where('isActive', true)
                    ->whereIn('id', $p)
                    ->first()
                    ->id;
                return Excel::download(new ManifiestoExport($ids), 'manifiesto.xlsx');
            } else {
                $this->error('Error, verifique los datos!');
            }
        } else {
            $this->error('Seleccione un vehiculo y transportista!');
        }
    }
    public function enableEncomienda(Encomienda $encomienda)
    {
        try {
            $encomienda->isActive = !$encomienda->isActive;
            $encomienda->save();
            $this->success('Genial, ingresado correctamente!');
        } catch (\Exception $e) {
            $this->error('Error, verifique los datos!');
        }
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
    public function editEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->editModal = true;
    }
    public function updateEncomienda()
    {
        if ($this->customerFormDest->code and $this->customerFormDest->type_code) {
            $this->encomienda->customer_dest_id = Customer::where('code', $this->customerFormDest->code)->where('type_code', $this->customerFormDest->type_code)->first()->id;

            $this->encomienda->isHome = $this->isHome;
            $this->customerFormDest->update();
            $this->encomienda->save();
            $this->editModal = false;
        }

    }
    public function searchDestinatario()
    {
        $this->customerFormDest->store();
    }
}
