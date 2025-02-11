<?php
namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Invoice;
use App\Models\Package\Customer;
use App\Models\Package\Paquete;
use App\Services\ServiceTableSunat;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Luecano\NumeroALetras\NumeroALetras;
use Mary\Traits\Toast;

class InvoiceCreateLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use SearchDocument;
    public $title         = 'Emitir Factura';
    public $sub_title     = 'Emitir Factura';
    public $tipoDocumento = '1';
    public $numDocumento  = '';
    public $razonSocial   = '';
    public $direccion     = '';
    public $ubigeo        = '';
    public $telefono      = '';
    public $paquetes;
    public $cantidad;
    public $und_medida = 'UND';
    public $description;
    public $peso;
    public $amount;
    public $sub_total;
    public $igv;
    public $total;
    public function mount()
    {
        $this->paquetes = collect([])->keyBy('id');
    }
    public function render()
    {
        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];
        $service       = new ServiceTableSunat();
        $tipoDocuments = $service->getAll('sunat_06');
        $ubigeos       = $service->getAll('ubigeo');
        return view('livewire.facturacion.invoice-create-live', compact('tipoDocuments', 'ubigeos', 'headers_paquetes'));
    }

    private function emitBoleta()
    {
        // Lógica para emitir boleta
    }

    public function emitFactura()
    {
        $formatter = new NumeroALetras();
        $factura = new Invoice();
        $factura->encomienda_id = $this->encomienda_id;
        $factura->tipoDoc = '03';
        $factura->tipoOperacion = '0101';
        $factura->serie = 'B001';
        $factura->correlativo = Invoice::where('tipoDoc', '03')->count() + 1;
        $factura->fechaEmision = now();
        $factura->formaPago_moneda = 'PEN';
        $factura->formaPago_tipo = '01';
        $factura->tipoMoneda = 'PEN';
        $factura->company_id = 1;
        $factura->client_id = 1;
        $factura->mtoOperGravadas = $this->sub_total;
        $factura->mtoIGV = $this->igv;
        $factura->totalImpuestos = $this->igv;
        $factura->valorVenta = $this->sub_total;
        $factura->subTotal = $this->total;
        $factura->mtoImpVenta = $this->total;
        $factura->monto_letras = $formatter->toInvoice($this->total, 2, 'SOLES');;
        $factura->save();
        $this->success('Factura emitida correctamente');
        dd($factura);
    }
    private function emitNotaCredito()
    {
        // Lógica para emitir factura
    }
    public function delete($id)
    {
        // Lógica para eliminar
    }
    public function buscarDocumento()
    {
        $rules = [
            'tipoDocumento' => 'required',
            'numDocumento'  => 'required',
            'numDocumento'  => 'numeric',
            'numDocumento'  => 'min:8',
            'numDocumento'  => 'max:11',
        ];
        $messages = [
            'tipoDocumento.required' => 'El tipo de documento es requerido',
            'numDocumento.required'  => 'El número de documento es requerido',
            'numDocumento.numeric'   => 'El número de documento debe ser un número',
            'numDocumento.min'       => 'El número de documento debe tener 8 dígitos',
            'numDocumento.max'       => 'El número de documento debe tener 11 dígitos',
        ];
        $this->validate($rules, $messages);
        $customer = Customer::where('type_code', $this->tipoDocumento)->where('code', $this->numDocumento)->first();
        if ($customer) {
            $this->razonSocial = $customer->name;
            $this->direccion   = $customer->address;
            $this->ubigeo      = $customer->ubigeo;
            return;
        }
        switch ($this->tipoDocumento) {
            case '1':
                $tipo = 'dni';
                break;
            case '6':
                $tipo = 'ruc';
                break;
            default:
                $tipo = 'dni';
                break;
        }
        $respuesta = $this->searchComplete($tipo, $this->numDocumento);
        if (! $respuesta['encontrado']) {
            $this->razonSocial = '';
            $this->direccion   = '';
            $this->ubigeo      = '';
            $this->error('El cliente no existe!, verifique el número de documento!');
            return;
        }
        elseif ($tipo == 'ruc') {
            $this->razonSocial = $respuesta['data']->razon_social;
            $this->direccion   = $respuesta['data']->direccion;
            $this->ubigeo      = $respuesta['data']->codigo_ubigeo;
        }
        elseif ($tipo == 'dni') {
            $this->razonSocial = $respuesta['data']->nombre;
            $this->direccion   = '';
            $this->ubigeo      = '';
        }
        Customer::firstOrCreate(
            ['type_code' => $this->tipoDocumento, 'code' => $this->numDocumento],
            ['name' => $this->razonSocial, 'address' => $this->direccion, 'ubigeo' => $this->ubigeo]
        );

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
            $this->calculateTotals();
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
        $this->paquetes->pull($id - 1);
        $this->calculateTotals();
    }

    public function resetPaquete()
    {
        $this->paquetes = collect([]);
        $this->calculateTotals();
    }
    public function calculateTotals()
    {
        $this->total = round($this->paquetes->sum('sub_total'), 2);//
        $this->sub_total = round($this->total / 1.18, 2);//
        $this->igv = round($this->total - $this->sub_total, 2);
    }
}
