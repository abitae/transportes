<?php
namespace App\Livewire\Facturacion;

use App\Models\Package\Customer;
use App\Services\ServiceTableSunat;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
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
    public function render()
    {
        $service       = new ServiceTableSunat();
        $tipoDocuments = $service->getAll('sunat_06');
        $ubigeos       = $service->getAll('ubigeo');
        return view('livewire.facturacion.invoice-create-live', compact('tipoDocuments', 'ubigeos'));
    }

    private function emitBoleta()
    {
        // Lógica para emitir boleta
    }

    private function emitFactura()
    {
        // Lógica para emitir factura
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
}
