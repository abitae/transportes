<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
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
    public int $sucursal_dest_id;
    public $date_ini;
    public $date_traslado;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id;
    public $vehiculo_id;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $caja;
    public $editModal = false;
    public $isHome;
    public CustomerForm $customerFormDest;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->sucursal_dest_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->get();

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
        }
    }
    public function sendPaquetes()
    {
        if (!is_null($this->vehiculo_id) and !is_null($this->transportista_id)) {

            $retorno = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->update([
                'estado_encomienda' => 'ENVIADO',
                'updated_at' => $this->date_traslado,
                'vehiculo_id' => $this->vehiculo_id,
                'transportista_id' => $this->transportista_id,
            ]);
            if (count($this->selected) == $retorno) {
                $this->success('Genial, ingresado correctamente!');
                $this->modalEnvio = false;
                $this->selected = [];
            } else {
                $this->error('Error, verifique los datos!');
            }
        }
    }
    public function enableEncomienda(Encomienda $encomienda)
    {
        //dump($encomienda);
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

    public function printEncomienda(Encomienda $envio)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, ($width / 25.4) * 72, ($heigh / 25.4) * 72);

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('report.pdf.ticket', compact('envio'));
        //return $pdf->stream();
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $envio->code . '.pdf');
    }
    public function editEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->editModal = true;
        $this->isHome = false;
    }
    public function updateEncomienda()
    {
        if ($this->customerFormDest->code and $this->customerFormDest->type_code) {
            $this->encomienda->customer_dest_id = Customer::where('code', $this->customerFormDest->code)->where('type_code', $this->customerFormDest->type_code)->first()->id;
            $this->encomienda->isHome = $this->isHome;
            $this->encomienda->save();
            $this->editModal = false;
        }

    }
    public function searchDestinatario()
    {
        $this->customerFormDest->store();
    }
}
