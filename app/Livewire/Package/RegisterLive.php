<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Livewire\Forms\EncomiendaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Paquete;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RegisterLive extends Component
{
    use LogCustom;
    use SearchDocument;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public int $step = 1;
    public $title = 'Registro';
    public $sub_title = 'Registrar paquetes de envio';

    public CustomerForm $customerForm, $customerFormDest, $customerFact;
    public EncomiendaForm $encomiendaForm;
    public $cantidad;
    public $description;
    public $peso;
    public $amount;

    public $paquetes;
    public $sucursal_destino;
    public $sucursal_dest_id;
    public $pin1;
    public $pin2;
    public $doc_traslado;
    public $estado_pago;
    public $tipo_comprobante;
    public $glosa;
    public $modalConfimation = false;
    public $caja;
    public $isReturn = false;
    public $isHome = false;
    public EntryCajaForm $entryForm;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->paquetes = collect([]);
        $this->sucursal_dest_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->first()->id;
        $this->estado_pago = 1;
        $this->tipo_comprobante = 3;

    }
    public function render()
    {
        $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
        ];

        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripcion', 'class' => ''],
            ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
            ['key' => 'amount', 'label' => 'P.UNIT', 'class' => ''],
            ['key' => 'sub_total', 'label' => 'MONTO', 'class' => ''],
        ];
        $sucursales = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->get();

        $pagos = [
            ['id' => 1, 'name' => 'PAGADO'],
            ['id' => 2, 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 1, 'name' => 'BOLETA'],
            ['id' => 2, 'name' => 'FACTURA'],
            ['id' => 3, 'name' => 'TICKET'],
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
        if (!is_null($this->cantidad) and !is_null($this->description) and !is_null($this->peso) and !is_null($this->amount)) {
            $paquete = new Paquete();
            $paquete->cantidad = $this->cantidad;
            $paquete->description = $this->description;
            $paquete->peso = $this->peso;
            $paquete->amount = $this->amount;
            $paquete->sub_total = $this->amount * $this->cantidad;
            $this->paquetes->push($paquete->toArray());
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function resetPaquete()
    {
        $this->paquetes = collect([]);
    }
    public function finish()
    {
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
        $this->encomiendaForm->code = 'BT-' . Auth::user()->id . Carbon::now()->setTimezone('America/Lima')->format('md-His') . '-' . rand(100, 999);
        $this->encomiendaForm->user_id = Auth::user()->id;
        $this->encomiendaForm->transportista_id = 1;
        $this->encomiendaForm->vehiculo_id = 1;
        $this->encomiendaForm->customer_id = Customer::firstOrCreate(
            ['type_code' => $this->customerForm->type_code, 'code' => $this->customerForm->code]
        )->id;
        $this->encomiendaForm->sucursal_id = Auth::user()->sucursal->id;
        $this->encomiendaForm->customer_dest_id = Customer::firstOrCreate(
            ['type_code' => $this->customerFormDest->type_code, 'code' => $this->customerFormDest->code]
        )->id;
        $this->encomiendaForm->sucursal_dest_id = $this->sucursal_dest_id;
        $this->encomiendaForm->cantidad = $this->paquetes->sum('cantidad');

        $this->encomiendaForm->monto = $this->paquetes->sum('sub_total');
        $this->encomiendaForm->estado_pago = $this->estado_pago;
        $this->encomiendaForm->tipo_pago = 'efectivo';
        if ($this->encomiendaForm->estado_pago == 2) {
            $this->encomiendaForm->tipo_comprobante = 3;
        } else {
            $this->encomiendaForm->tipo_comprobante = $this->tipo_comprobante;
        }
        $this->encomiendaForm->doc_traslado = $this->doc_traslado;
        $this->encomiendaForm->glosa = $this->glosa;
        $this->encomiendaForm->estado_encomienda = 'REGISTRADO';
        $this->encomiendaForm->pin = $this->pin1;
        $this->encomiendaForm->isHome = $this->isHome;
        $this->encomiendaForm->isReturn = $this->isReturn;
        if ($this->encomiendaForm->store($this->paquetes, $this->customerFact)) {
            $this->success('Genial, ingresado correctamente!');
            $this->modalConfimation = false;

            $this->entryForm->caja_id = $this->caja->id;
            $this->entryForm->monto_entry = $this->encomiendaForm->monto;
            $this->entryForm->description = $this->encomiendaForm->code;
            $this->entryForm->tipo = 'ENVIO ENCOMIENDA';

            if ($this->entryForm->store()) {

                $this->entryForm->reset();
            } else {

            }

            $this->redirectRoute('package.register');
        } else {
            $this->error('Error, verifique los datos!');
        }

    }
}
