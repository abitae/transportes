<?php
namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EntryCajaForm;
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

class DeliverPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination, InvoiceTrait;

    public EntryCajaForm $entryForm;
    public CustomerForm $customerFact;
    public $title     = 'Entrega paquetes';
    public $sub_title = 'Modulo de entrega de paquetes';
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
    public $tipo_comprobante = 'TICKET';
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
        $this->sucursal_id = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->first()->id;
        $this->date_ini      = now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = now()->setTimezone('America/Lima')->format('Y-m-d');
    }

    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)
            ->whereNot('id', [Auth::user()->sucursal->id])
            ->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isHome', false)
        //->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%'))
            ->whereHas('destinatario', function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.deliver-package-live', compact('encomiendas', 'sucursals'));
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function openModal(Encomienda $encomienda)
    {
        $this->modalDeliver = ! $this->modalDeliver;
        $this->encomienda   = $encomienda;
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
            $this->toast('error', 'Datos incorrectos');
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
            } else {
                $this->updateEncomiendaStatus('ENTREGADO', $this->tipo_comprobante);
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
