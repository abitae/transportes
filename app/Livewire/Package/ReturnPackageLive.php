<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReturnPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    public EntryCajaForm $entryForm;
    public CustomerForm $customerFact;
    public $title     = 'Entrega paquetes retorno';
    public $sub_title = 'Modulo de entrega de paquetes retorno';
    public $caja;
    public int $sucursal_id;
    public $date_ini;
    public $search    = '';
    public $perPage   = 10;
    public $encomienda;
    public $document;
    public $pin;
    public $modalDeliver = false;
    public $tipo_comprobante;
    public $estado_pago;
    public bool $modalConfimation;
    public $showDrawer;
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
      
    }
    public function render()
    {
        $sucursals   = Sucursal::where('isActive', true)->whereNot('id', [Auth::user()->sucursal->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isReturn', true)
            //->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            ->whereHas('destinatario', function ($query) {
                $query->where('code', 'like', '%'.$this->search.'%')
                    ->orWhere('name', 'like', '%'.$this->search.'%');
            })
            ->latest()
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.return-package-live', compact('encomiendas', 'sucursals'));
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
        if ($this->encomienda->destinatario->code == $this->document) {
            $this->customerFact->setCustomer($this->encomienda->destinatario);
            $this->estado_pago      = $this->encomienda->estado_pago;
            $this->modalDeliver     = false;
            $this->modalConfimation = true;
        } else {
            $this->toast('error', 'Error', 'Datos incorrectos');
        }
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
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
