<?php
namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Manifiesto;
use App\Traits\CajaTrait;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Excel;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use CajaTrait, UtilsTrait;
    public $title = 'ENVIAR PAQUETES';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id = 0;
    public $date_ini;
    public $date_fin;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id = 1;
    public $vehiculo_id = 1;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public $modalFinal;
    public $manifiesto;
    public $date_traslado;
    public function mount()
    {
        $this->date_traslado = Carbon::now()->endOfDay()->format('Y-m-d H:i');
        $this->date_ini = Carbon::now()->startOfDay()->format('Y-m-d H:i');//$this->dateNow('Y-m-d');
        $this->date_fin = $this->dateNow('Y-m-d H:i:s');

        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        if ($p->isEmpty()) {
            return redirect()->route('caja.index');
        }

        $this->sucursal_dest_id = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->first()
            ->id;
    }
    public function render()
    {
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        $sucursals = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->get();

        $config = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_destino_id', $this->sucursal_dest_id)
            ->first();

        $this->transportista_id = $config->transportista_id;
        $this->vehiculo_id = $config->vehiculo_id;

        // Build base query with date range filter
        $encomiendas = Encomienda::query()
            ->when($this->date_ini && $this->date_fin, function($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->date_ini)->startOfDay(),
                    Carbon::parse($this->date_fin)->endOfDay()
                ]);
            })
            ->where([
                'isActive' => $this->isActive,
                'sucursal_id' => Auth::user()->sucursal->id,
                'sucursal_dest_id' => $this->sucursal_dest_id,
            ])
            ->whereIn('estado_encomienda' , ['REGISTRADO','RETORNADO'])
            // Search in related models and package code
            ->when($this->search, function($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('remitente', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhere('code', 'like', $searchTerm)
                    ->orWhereHas('destinatario', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page');

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
        if ($this->vehiculo_id && $this->transportista_id) {
            $vehiculo_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->vehiculo_id;
            $transportista_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->transportista_id;
            if ($vehiculo_id != $this->vehiculo_id || $transportista_id != $this->transportista_id) {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                        'isTransbordo' => true,
                    ]);
            } else {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                    ]);
            }
            if (count($this->selected) == $num_encomiendas_enviadas) {
                $this->success('Genial, enviado correctamente!');
                $this->modalEnvio = false;
                $ids = $this->selected;
                $this->selected = [];
                $this->manifiesto = Manifiesto::create([
                    'sucursal_id' => Auth::user()->sucursal->id,
                    'sucursal_destino_id' => $this->sucursal_dest_id,
                    'ids' => json_encode($ids),
                ]);
                SucursalConfiguration::where('sucursal_id', Auth::user()->sucursal->id)
                    ->where('sucursal_destino_id', $this->sucursal_dest_id)
                    ->update(['isActive' => false]);

                $p = SucursalConfiguration::where('isActive', true)
                    ->where('sucursal_id', Auth::user()->sucursal->id)
                    ->pluck('sucursal_destino_id');
                if ($p->isEmpty()) {

                    return redirect()->route('caja.index');
                } else {
                    $this->sucursal_dest_id = Sucursal::where('isActive', true)
                        ->whereIn('id', $p)
                        ->first()
                        ->id;
                }
                $this->modalFinal = true;
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
        if ($this->customerFormDest->code && $this->customerFormDest->type_code) {
            $this->encomienda->customer_dest_id = Customer::where('code', $this->customerFormDest->code)
                ->where('type_code', $this->customerFormDest->type_code)
                ->first()
                ->id;

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
    public function excelGenerate(Manifiesto $manifiesto)
    {
        $this->toast('success', 'Generando Excel', 'Manifiesto');
        return Excel::download(new ManifiestoExport(json_decode($manifiesto->ids)), 'manifiesto.xlsx');
    }
}
