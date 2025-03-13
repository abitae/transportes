<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
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
    public ExitCajaForm $exitForm;
    public CustomerForm $customerFact;
    public $title     = 'ENTREGA PAQUETES AGENCIA';
    public $sub_title = 'Modulo de entrega de paquetes en agencia';
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
    public bool $modalDescuento;
    public $monto_descuento;
    public $motivo_descuento;
    public $modalFinal;
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

        $encomiendas = Encomienda::where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isHome', false)
            ->whereHas('destinatario', function ($query) {
            $query->where('code', 'like', '%' . $this->search . '%')
                ->orWhere('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage, '*', 'page');

        $pagos = [
            ['id' => 'PAGADO', 'name' => 'PAGADO'],
            ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 'BOLETA', 'name' => 'BOLETA'],
            ['id' => 'FACTURA', 'name' => 'FACTURA'],
            ['id' => 'TICKET', 'name' => 'TICKET'],
        ];
        $tipoDocuments = [
            ['codigo' => '0', 'sigla' => 'OTRO DOCUMENTO cod(0)'],
            ['codigo' => '1', 'sigla' => 'DNI cod(1)'],
            ['codigo' => '6', 'sigla' => 'RUC cod(6)'],
        ];
        return view('livewire.package.deliver-package-live', compact('encomiendas', 'sucursals', 'pagos', 'comprobantes', 'tipoDocuments'));
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function openModal(Encomienda $encomienda)
    {
        $this->document = $encomienda->destinatario->code;
        $this->pin      = '';
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
            $this->error('Error', 'Datos incorrectos');
        }
    }

    public function confirmEncomienda()
    {
        if ($this->estado_pago == 'PAGADO') {
            $this->updateEncomiendaStatus('ENTREGADO');
            $this->success('Paquete entregado correctamente');
        } else {
            if ($this->tipo_comprobante != 'TICKET') {
                $this->setInvoice($this->encomienda,$this->tipo_comprobante);
            }
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
                $this->error('Error, no se pudo registrar la entrada de caja!');
            }
            if ($this->encomienda->monto_descuento) {
                $this->exitForm->fill([
                    'caja_id'     => $this->caja->id,
                    'monto_exit' => $this->encomienda->monto_descuento,
                    'description' => $this->encomienda->code,
                    'tipo'        => 'DESCUENTO',
                ]);
                if ($this->exitForm->store()) {
                    $this->exitForm->reset();
                } else {
                    $this->error('Error, no se pudo registrar la salida de caja!');
                }
            }
        }
        $this->modalConfimation = false;
        $this->modalFinal       = true;
    }

    private function updateEncomiendaStatus($status, $tipo_comprobante = null)
    {
        $this->encomienda->estado_encomienda = $status;
        $this->encomienda->estado_pago       = 'PAGADO';
        if ($tipo_comprobante) {
            $this->encomienda->tipo_comprobante = $tipo_comprobante;
        }
        $this->encomienda->save();
    }

    public function searchFacturacion()
    {
        $this->customerFact->store();
    }

    public function descuento(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->modalDescuento = true;
    }

    public function descuentoCreate()
    {

        $rules = [
            'monto_descuento' => 'required|numeric|min:0',
            'motivo_descuento' => 'required|string|max:255',
        ];
        $messages = [
            'monto_descuento.required' => 'El monto de descuento es requerido',
            'monto_descuento.numeric' => 'El monto de descuento debe ser un número',
            'monto_descuento.min' => 'El monto de descuento debe ser mayor que 0',
            'motivo_descuento.required' => 'El motivo del descuento es requerido',
            'motivo_descuento.string' => 'El motivo del descuento debe ser una cadena de texto',
            'motivo_descuento.max' => 'El motivo del descuento debe tener menos de 255 caracteres',
        ];

        $this->validate($rules, $messages);

        if ($this->encomienda->monto < $this->monto_descuento) {
            $this->modalDescuento = false;
            $this->error('Error', 'El monto de descuento no puede ser mayor al monto de la encomienda');
            return;
        }
        $this->encomienda->monto_descuento = $this->monto_descuento;
        $this->encomienda->motivo_descuento = $this->motivo_descuento;
        if ($this->encomienda->ticket) {
            $this->encomienda->ticket->monto_descuento = $this->monto_descuento;
            $this->encomienda->ticket->motivo_descuento = $this->motivo_descuento;
            $this->encomienda->ticket->save();
        }
        $this->encomienda->save();
        $this->modalDescuento = false;
        $this->success('Descuento aplicado correctamente');
    }

    public function descuentoDelete(Encomienda $encomienda)
    {
        $encomienda->monto_descuento = null;
        $encomienda->motivo_descuento = null;
        if ($encomienda->ticket) {
            $encomienda->ticket->monto_descuento = null;
            $encomienda->ticket->motivo_descuento = null;
            $encomienda->ticket->save();
        }

        $encomienda->save();
        $this->dispatch('refreshEncomienda');
        $this->success('Descuento eliminado correctamente');
    }
}
