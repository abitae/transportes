<?php
namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class HomePackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use InvoiceTrait;
    public CustomerForm $customerFact;
    public $title     = 'Entrega paquetes destino';
    public $sub_title = 'Modulo de entrega de paquetes domicilio';
    public $search    = '';
    public $perPage   = 10;
    public $date_ini;
    public int $sucursal_id;
    public $date_traslado;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalDeliver = false;
    public $encomienda;
    public $document;
    public $pin;
    public $showDrawer;
    public $estado_pago;
    public $tipo_comprobante;
    public $caja;
    public bool $modalConfimation;

    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (! $this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->sucursal_id   = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->first()->id;
        $this->date_ini      = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }

    public function render()
    {
        $sucursals   = Sucursal::where('isActive', true)->whereNot('id', [Auth::user()->sucursal->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isHome', true)
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.home-package-live', compact('encomiendas', 'sucursals'));
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function openModal($id)
    {
        //dd($id);
        $this->encomienda       = Encomienda::find($id);
        $this->modalDeliver     = ! $this->modalDeliver;
        $this->tipo_comprobante = $this->encomienda->tipo_comprobante;
        
    }

    public function deliverPaquetes()
    {
        if ($this->encomienda->isHome) {
            $this->pin = 123;
        }
        if ($this->encomienda->destinatario->code == $this->document && $this->encomienda->pin == $this->pin) {
            $this->customerFact->setCustomer($this->encomienda->destinatario);
            $this->estado_pago      = $this->encomienda->estado_pago;
            $this->modalDeliver     = false;
            $this->modalConfimation = true;
        } else {

        }
    }

    public function confirmEncomienda()
    {
        if ($this->estado_pago == 'PAGADO') {
            $this->updateEncomiendaStatus('ENTREGADO');
            $this->toast('success', 'Paquete entregado correctamente');
        } else {
            if ($this->tipo_comprobante != 'TICKET') {
                $this->updateEncomiendaStatus('ENTREGADO', $this->tipo_comprobante);
                $this->setInvoice($this->encomienda);
                $this->entryForm->fill([
                    'caja_id'     => $this->caja->id,
                    'monto_entry' => $this->encomienda->monto,
                    'description' => $this->encomienda->code,
                    'tipo'        => $this->encomienda->tipo_comprobante,
                ]);
                if ($this->entryForm->store()) {
                    $this->entryForm->reset();
                } else {
                    $this->error('Error, verifique los datos!');
                }
            }
        }
        $this->modalConfimation = false;
    }
    private function updateEncomiendaStatus($status, $tipo_comprobante = null)
    {
        $this->encomienda->estado_encomienda = $status;
        if ($tipo_comprobante) {
            $this->encomienda->tipo_comprobante = $tipo_comprobante;
        }
        $this->encomienda->save();
    }

    public function searchFacturacion()
    {
        $this->customerFact->store();
    }
}
