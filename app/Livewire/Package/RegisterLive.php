<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EncomiendaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Paquete;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RegisterLive extends Component
{
    use LogCustom;
    use Toast;
    use InvoiceTrait;
    use WithPagination, WithoutUrlPagination;
    public int $step = 1;
    public $title = 'Registro';
    public $sub_title = 'Registrar paquetes de envio';

    public CustomerForm $customerForm, $customerFormDest, $customerFact;
    public EncomiendaForm $encomiendaForm;
    public $cantidad;
    public $und_medida = 'UND';
    public $description;
    public $peso;
    public $amount;

    public $paquetes;
    public $sucursal_destino;
    public $sucursal_dest_id;
    public $pin1;
    public $pin2;
    public $doc_traslado;
    public $estado_pago = 'PAGADO';
    public $tipo_comprobante = 'TICKET';
    public $glosa;
    public $observation;
    public $transportista_id;
    public $vehiculo_id;
    public $modalConfimation = false;
    public $caja;
    public $isReturn = false;
    public $isHome = false;
    public $modalFinal = false;
    public EntryCajaForm $entryForm;
    public $encomienda;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();

        $this->paquetes = collect([]);
        $this->paquetes->keyBy('id');

        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');
        //Sucursales activas segun configuracion
        //dd(!$p->isEmpty(), !$this->caja);
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
        //Sucursal destino

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
        $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
        ];
        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => ''],
            ['key' => 'und_medida', 'label' => 'Unidad', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripcion', 'class' => ''],
            ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
            ['key' => 'amount', 'label' => 'P.UNIT', 'class' => ''],
            ['key' => 'sub_total', 'label' => 'MONTO', 'class' => ''],
        ];
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');
        $sucursales = Sucursal::where('isActive', true)->whereIn('id', $p)->get();
        $pagos = [
            ['id' => 'PAGADO', 'name' => 'PAGADO'],
            ['id' => 'CONTRA ENTREGA', 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 'BOLETA', 'name' => 'BOLETA'],
            ['id' => 'FACTURA', 'name' => 'FACTURA'],
            ['id' => 'TICKET', 'name' => 'TICKET'],
        ];
        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        return view('livewire.package.register-live', compact('docs', 'headers_paquetes', 'sucursales', 'pagos', 'comprobantes', 'transportistas', 'vehiculos'));
    }
    public function searchRemitente()
    {
        $this->customerForm->store();
    }
    public function searchDestinatario()
    {
        $this->customerFormDest->store();
    }
    public function searchFacturacion()
    {
        $this->customerFact->store();
    }
    public function next()
    {
        if ($this->step < 4) {
            switch ($this->step) {
                case 1:
                    if ($this->customerForm->update()) {
                        $this->step++;
                        $this->success('Genial, ingresado correctamente!');
                    } else {
                        $this->error('Error, verifique los datos!');
                    }
                    break;
                case 2:
                    if ($this->customerFormDest->update()) {
                        if ($this->isHome) {
                            if ($this->customerFormDest->address) {
                                $this->step++;
                                $this->success('Genial, ingresado correctamente!');

                            } else {
                                $this->error('Error, es necesario  ingresar la dirección de entrega!');
                            }
                        } else {
                            $this->step++;
                            $this->success('Genial, ingresado correctamente!');
                        }

                    } else {
                        $this->error('Error, verifique los datos!');
                    }
                    break;
                case 3:
                    if ($this->paquetes->isNotEmpty()) {
                        $this->step++;
                        $this->success('Genial, ingresado correctamente!');
                    } else {
                        $this->error('Error, verifique los datos!');
                    }
                    break;
            }
        }
    }
    public function prev()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
    public function addPaquete()
    {
        $id = $this->paquetes->count();
        //$paquete = null;
        if (!is_null($this->cantidad) and !is_null($this->description) and !is_null($this->peso) and !is_null($this->amount)) {
            $paquete = new Paquete();
            $paquete->id = $id + 1;
            $paquete->cantidad = $this->cantidad;
            $paquete->und_medida = $this->und_medida;
            $paquete->description = $this->description;
            $paquete->peso = $this->peso;
            $paquete->amount = $this->amount;
            $paquete->sub_total = $this->amount * $this->cantidad;
            $this->paquetes->push($paquete->toArray());
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function restPaquete($id)
    {
        $this->paquetes->pull($id - 1);
    }
    public function resetPaquete()
    {
        $this->paquetes = collect([]);
    }
    public function finish()
    {
        if ($this->isHome) {
            $this->pin1 = 123;
            $this->pin2 = $this->pin1;
        }
        if (isset($this->sucursal_dest_id) and isset($this->pin1) and isset($this->pin2) and $this->pin1 == $this->pin2) {
            $this->sucursal_destino = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->customerFact = $this->customerForm;
            $this->modalConfimation = true;
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function confirmEncomienda()
    {
        $cod = Sucursal::where('id', Auth::user()->sucursal->id)->first()->code;
        $correlativo = count(Encomienda::all()) + 1;
        $this->encomiendaForm->code = $cod . '-' . Auth::user()->id . $correlativo;
        $this->encomiendaForm->user_id = Auth::user()->id;
        $this->encomiendaForm->transportista_id = $this->transportista_id;
        $this->encomiendaForm->vehiculo_id = $this->vehiculo_id;
        $this->encomiendaForm->customer_id = Customer::firstOrCreate(
            ['type_code' => $this->customerForm->type_code, 'code' => $this->customerForm->code]
        )->id;
        $this->encomiendaForm->sucursal_id = Auth::user()->sucursal->id;
        $this->encomiendaForm->customer_dest_id = Customer::firstOrCreate(
            ['type_code' => $this->customerFormDest->type_code, 'code' => $this->customerFormDest->code]
        )->id;
        $this->encomiendaForm->sucursal_dest_id = $this->sucursal_dest_id;
        $this->encomiendaForm->customer_fact_id = Customer::firstOrCreate(
            ['type_code' => $this->customerFact->type_code, 'code' => $this->customerFact->code]
        )->id;
        $this->encomiendaForm->cantidad = $this->paquetes->sum('cantidad');

        $this->encomiendaForm->monto = $this->paquetes->sum('sub_total');
        $this->encomiendaForm->estado_pago = $this->estado_pago;
        $this->encomiendaForm->tipo_pago = 'Contado';
        if ($this->encomiendaForm->estado_pago == 'CONTRA ENTREGA') {
            $this->encomiendaForm->tipo_comprobante = 'TICKET';
        } else {
            $this->encomiendaForm->tipo_comprobante = $this->tipo_comprobante;
        }
        $this->encomiendaForm->doc_traslado = $this->doc_traslado;
        $this->encomiendaForm->glosa = $this->glosa;
        $this->encomiendaForm->observation = $this->observation;
        $this->encomiendaForm->estado_encomienda = 'REGISTRADO';
        $this->encomiendaForm->pin = $this->pin1;
        $this->encomiendaForm->isHome = $this->isHome;
        $this->encomiendaForm->isReturn = $this->isReturn;
        $this->encomienda = $this->encomiendaForm->store($this->paquetes);
        if (!is_null($this->encomienda)) {
            $this->entryForm->caja_id = $this->caja->id;
            $this->entryForm->monto_entry = $this->encomiendaForm->monto;
            $this->entryForm->description = $this->encomiendaForm->code;
            $this->entryForm->tipo = $this->encomiendaForm->tipo_comprobante;
            if ($this->entryForm->store()) {
                $this->entryForm->reset();

                //Generacion de documento PDF
                $this->storeInvoce($this->encomienda); // Genera recibo

                $this->encomiendaForm->reset();
            } else {
                $this->error('Error, verifique los datos!');
            }
            $this->success('Genial, ingresado correctamente!');
            $this->modalConfimation = false;
            $this->modalFinal = true;
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function redirectionRegister()
    {
        $this->redirectRoute('package.register');
    }
    public function redirectionSend()
    {
        $this->redirectRoute('package.send');
    }
    public function openModal()
    {
        $this->modalFinal = true;
    }
}
