<?php
namespace App\Livewire\Facturacion;

use App\Services\ServiceTableSunat;
use App\Traits\SearchDocument;
use Livewire\Component;

class InvoiceCreateLive extends Component
{
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
            return;
        }
        elseif ($tipo == 'ruc') {
            $this->razonSocial = $respuesta['data']->razon_social;
            $this->direccion   = $respuesta['data']->direccion;
            $this->ubigeo      = $respuesta['data']->codigo_ubigeo;
        }
        elseif ($tipo == 'dni') {
            //dd($respuesta);
            $this->razonSocial = $respuesta['data']->nombre;
            $this->direccion   = '';
            $this->ubigeo      = '';
        }

    }
}
