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
use App\Traits\CajaTrait;
use App\Traits\InvoiceTrait;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RegisterLive extends Component
{
    use LogCustom, Toast, InvoiceTrait, WithPagination, WithoutUrlPagination;
    use CajaTrait;
    public int $step  = 1;
    public $title     = 'Registro';
    public $sub_title = 'Registrar paquetes de envio';

    public CustomerForm $customerForm, $customerFormDest, $customerFact;
    public EncomiendaForm $encomiendaForm;
    public EntryCajaForm $entryForm;

    public $cantidad, $und_medida = 'UND', $description, $peso, $amount;
    public $paquetes, $sucursal_destino, $sucursal_dest_id, $pin1, $pin2, $doc_traslado;
    public $estado_pago                                       = 'PAGADO', $tipo_comprobante                                       = 'TICKET', $glosa, $observation;
    public $transportista_id, $vehiculo_id, $modalConfimation = false, $caja, $isReturn = false, $isHome = false, $modalFinal = false;
    public $encomienda;

    public function mount()
    {
        $this->caja     = $this->cajaIsActive(Auth::user());
        $this->paquetes = collect([])->keyBy('id');

        $sucursalConfig     = SucursalConfiguration::where('isActive', true)->where('sucursal_id', Auth::user()->sucursal->id);
        $sucursalDestinoIds = $sucursalConfig->pluck('sucursal_destino_id');

        if (! $this->caja || $sucursalDestinoIds->isEmpty()) {
            return $this->redirectRoute('caja.index');
        }

        $this->sucursal_dest_id = Sucursal::where('isActive', true)->whereIn('id', $sucursalDestinoIds)->first()->id;
    }

    public function render()
    {
        $sucursalConfig     = SucursalConfiguration::where('isActive', true)->where('sucursal_id', Auth::user()->sucursal->id);
        $sucursalDestinoIds = $sucursalConfig->pluck('sucursal_destino_id');

        $sucursales             = Sucursal::where('isActive', true)->whereIn('id', $sucursalDestinoIds)->get();
        $transportistaConfig    = $sucursalConfig->where('sucursal_destino_id', $this->sucursal_dest_id)->first();
        $this->transportista_id = $transportistaConfig->transportista_id;
        $this->vehiculo_id      = $transportistaConfig->vehiculo_id;

        $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
        ];

        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];

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
        $vehiculos      = Vehiculo::where('isActive', true)->get();

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
                    $this->processStep(isset($this->customerForm->customer), 'Error, es necesario ingresar el remitente!');
                    $this->customerForm->update();
                    break;
                case 2:
                    $this->processStep(isset($this->customerFormDest->customer), 'Error, es necesario ingresar la dirección de entrega!');
                    $this->customerFormDest->update();
                    break;
                case 3:
                    $this->processStep($this->paquetes->isNotEmpty(), 'Error, verifique los datos!');
                    break;
            }
        }
    }

    private function processStep($condition, $errorMessage)
    {       
        if ($this->isHome && ! $this->customerFormDest->address) {
            $this->error('Error, es necesario ingresar la dirección de entrega!');
            return;
        }
        if ($condition) {
            $this->step++;
            $this->success('Genial, ingresado correctamente!');
        } else {
            $this->error($errorMessage);
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
        if ($this->validatePaquete()) {
            $paquete = new Paquete();
            $paquete->id = $this->paquetes->count() + 1;
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

    private function validatePaquete()
    {
        $validations = [
            'cantidad'    => 'required|numeric',
            'und_medida'  => 'required',
            'description' => 'required',
            'peso'        => 'required|numeric',
            'amount'      => 'required|numeric',
        ];
        $errorMessage = [
            'cantidad.required'    => 'Error, es necesario ingresar la cantidad!',
            'cantidad.numeric'     => 'Error, la cantidad debe ser un número!',
            'und_medida.required'  => 'Error, es necesario ingresar la unidad de medida!',
            'description.required' => 'Error, es necesario ingresar la descripción!',
            'peso.required'        => 'Error, es necesario ingresar el peso!',
            'peso.numeric'         => 'Error, el peso debe ser un número!',
            'amount.required'      => 'Error, es necesario ingresar el precio unitario!',
            'amount.numeric'       => 'Error, el precio unitario debe ser un número!',
        ];
        $this->validate($validations, $errorMessage);
        
        return true;   
    }

    public function restPaquete($id)
    {
        dump($id);
        $this->paquetes->pull($id - 1);
    }

    public function resetPaquete()
    {
        $this->paquetes = collect([]);
    }

    public function finish()
    {
        if ($this->isReturn) {
            //dd($this->customerFormDest->address,$this->isHome);
            if (! $this->customerFormDest->address) {
                $this->error('Error, es necesario ingresar la dirección de entrega!');
                $this->step = 2;
                $this->isHome = true;
                return;
            }
        }
        if ($this->isHome) {
            $this->pin1 = $this->pin2 = 123;
        }

        if ($this->validateFinish()) {
            $this->sucursal_destino = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->customerFact     = $this->customerForm;
            $this->modalConfimation = true;
        } else {
            $this->error('Error, el pin ingresado no es correcto!');
        }
    }

    private function validateFinish()
    {
        return isset($this->sucursal_dest_id, $this->pin1, $this->pin2) && $this->pin1 == $this->pin2;
    }

    public function confirmEncomienda()
    {
        $this->encomiendaForm->fill([
            'code'              => $this->generateCode(),
            'user_id'           => Auth::user()->id,
            'transportista_id'  => $this->transportista_id,
            'vehiculo_id'       => $this->vehiculo_id,
            'customer_id'       => $this->getCustomerId($this->customerForm),
            'sucursal_id'       => Auth::user()->sucursal->id,
            'customer_dest_id'  => $this->getCustomerId($this->customerFormDest),
            'sucursal_dest_id'  => $this->sucursal_dest_id,
            'customer_fact_id'  => $this->getCustomerId($this->customerFact),
            'cantidad'          => $this->paquetes->sum('cantidad'),
            'monto'             => $this->paquetes->sum('sub_total'),
            'estado_pago'       => $this->estado_pago,
            'tipo_pago'         => 'Contado',
            'tipo_comprobante'  => $this->estado_pago == 'CONTRA ENTREGA' ? 'TICKET' : $this->tipo_comprobante,
            'doc_traslado'      => $this->doc_traslado,
            'glosa'             => $this->glosa,
            'observation'       => $this->observation,
            'estado_encomienda' => 'REGISTRADO',
            'pin'               => $this->pin1,
            'isHome'            => $this->isHome,
            'isReturn'          => $this->isReturn,
        ]);
        $this->customerFact->update();
        //dd($this->paquetes);
        $this->encomienda = $this->encomiendaForm->store($this->paquetes);

        if ($this->encomienda) {
            if ($this->encomienda->estado_pago != 'CONTRA ENTREGA') {
                $this->storeEntry();
            }
            $this->storeInvoce($this->encomienda);
            $this->resetForms();
            $this->success('Genial, ingresado correctamente!');
            $this->modalConfimation = false;
            $this->modalFinal       = true;
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

    private function generateCode()
    {
        $cod         = Sucursal::where('id', Auth::user()->sucursal->id)->first()->code;
        $correlativo = Encomienda::count() + 1;
        return $cod . '-' . Auth::user()->id . $correlativo;
    }

    private function getCustomerId($form)
    {
        return Customer::firstOrCreate(['type_code' => $form->type_code, 'code' => $form->code])->id;
    }

    private function storeEntry()
    {
        $this->entryForm->fill([
            'caja_id'     => $this->caja->id,
            'monto_entry' => $this->encomiendaForm->monto,
            'description' => $this->encomiendaForm->code,
            'tipo'        => $this->encomiendaForm->tipo_comprobante,
        ]);

        if ($this->entryForm->store()) {
            $this->entryForm->reset();
        } else {
            $this->error('Error, no se pudo ingresar monto a caja!');
        }
    }

    private function resetForms()
    {
        $this->encomiendaForm->reset();
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
