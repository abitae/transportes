<?php

namespace App\Livewire\Facturacion;

use App\Services\ServiceTableSunat;
use Livewire\Component;

class InvoiceCreateLive extends Component
{
    public $title = 'Emitir Factura';
    public $sub_title = 'Emitir Factura';
    public $factura;
    public $boleta;
    public $amount;


    public function render()
    {
        $tabla = new ServiceTableSunat('sunat_06');
        $data = $tabla->getAll();
        $unique = $tabla->findById('codigo','01');
        //dd($data,$unique);
        return view('livewire.facturacion.invoice-create-live', compact('data', 'unique'));
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
}
