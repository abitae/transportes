<?php
namespace App\Traits;

use App\Models\Configuration\Company;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\InvoiceDetail;
use App\Models\Facturacion\Ticket;
use App\Models\Facturacion\TicketDetail;
use App\Models\Package\Encomienda;

trait InvoiceTrait
{
    function storeInvoce(Encomienda $encomienda)
    {
        
        switch ($encomienda->tipo_comprobante) {
            case 'TICKET':
                $this->setTicket($encomienda);
                break;
            case 'BOLETA':
                $this->setBoleta($encomienda);
                break;
            case 'FACTURA':
                $this->setTFactura($encomienda);
                break;
            case 'GUIA':
                $this->setGuiTrans($encomienda);
                break;
            default:
                break;
        } 
    }
    private function setTicket(Encomienda $encomienda) {
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $correlativo = Ticket::all()->count();
        if ($encomienda->tipo_comprobante == 'TICKET') {
            $ticket = Ticket::create([
                'tipoDoc' => 'TICKET',
                'tipoOperacion' => '0',
                'serie' => '001',
                'correlativo' => $correlativo + 1,
                'fechaEmision' => $encomienda->created_at,
                'formaPago_moneda' => 'PEN',
                'formaPago_tipo' => $encomienda->tipo_pago,
                'tipoMoneda' => 'PEN',
                'company_id' => $company->id,
                'client_id' => $encomienda->customer_id,
                'mtoOperGravadas' => $mtoOperGravadas,
                'mtoIGV' => $igv,
                'totalImpuestos' => $igv,
                'valorVenta' => $mtoOperGravadas,
                'subTotal' => $montoTotalIncIGV,
                'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            ]);
            foreach ($encomienda->paquetes as $paquete) {
                $mtoValorUnitario = round($paquete->amount / 1.18, 2);
                TicketDetail::create([
                    'ticket_id' => $ticket->id,
                    'tipAfeIgv' => '10',
                    'codProducto' => $paquete->id,
                    'unidad' => 'NIU',
                    'descripcion' => 'Servicio de traslado ' . $paquete->description,
                    'cantidad' => $paquete->cantidad,
                    'mtoValorUnitario' => $mtoValorUnitario,
                    'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
                    'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
                    'porcentajeIgv' => 18,
                    'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'mtoPrecioUnitario' => $paquete->amount,
                ]);
            }
        }
    }
    private function setBoleta(Encomienda $encomienda) {
        dump($encomienda,'Boleta');
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $correlativo = Invoice::all()->count();
        if ($encomienda->tipo_comprobante == 'BOLETA') {
            $invoice = Invoice::create([
                'tipoDoc' => 'BOLETA',
                'tipoOperacion' => '0',
                'serie' => '001',
                'correlativo' => $correlativo + 1,
                'fechaEmision' => $encomienda->created_at,
                'formaPago_moneda' => 'PEN',
                'formaPago_tipo' => $encomienda->tipo_pago,
                'tipoMoneda' => 'PEN',
                'company_id' => $company->id,
                'client_id' => $encomienda->customer_id,
                'mtoOperGravadas' => $mtoOperGravadas,
                'mtoIGV' => $igv,
                'totalImpuestos' => $igv,
                'valorVenta' => $mtoOperGravadas,
                'subTotal' => $montoTotalIncIGV,
                'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            ]);
            foreach ($encomienda->paquetes as $paquete) {
                $mtoValorUnitario = round($paquete->amount / 1.18, 2);
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'tipAfeIgv' => '10',
                    'codProducto' => $paquete->id,
                    'unidad' => 'NIU',
                    'descripcion' => 'Servicio de traslado ' . $paquete->description,
                    'cantidad' => $paquete->cantidad,
                    'mtoValorUnitario' => $mtoValorUnitario,
                    'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
                    'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
                    'porcentajeIgv' => 18,
                    'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'mtoPrecioUnitario' => $paquete->amount,
                ]);
            }
        }
    }
    private function setTFactura(Encomienda $encomienda) {
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $correlativo = Invoice::all()->count();
        if ($encomienda->tipo_comprobante == 'FACTURA') {
            $invoice = Invoice::create([
                'tipoDoc' => 'FACTURA',
                'tipoOperacion' => '0',
                'serie' => '001',
                'correlativo' => $correlativo + 1,
                'fechaEmision' => $encomienda->created_at,
                'formaPago_moneda' => 'PEN',
                'formaPago_tipo' => $encomienda->tipo_pago,
                'tipoMoneda' => 'PEN',
                'company_id' => $company->id,
                'client_id' => $encomienda->customer_id,
                'mtoOperGravadas' => $mtoOperGravadas,
                'mtoIGV' => $igv,
                'totalImpuestos' => $igv,
                'valorVenta' => $mtoOperGravadas,
                'subTotal' => $montoTotalIncIGV,
                'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            ]);
            foreach ($encomienda->paquetes as $paquete) {
                $mtoValorUnitario = round($paquete->amount / 1.18, 2);
                InvoiceDetail::create([
                    'invoice_id' => $invoice->id,
                    'tipAfeIgv' => '10',
                    'codProducto' => $paquete->id,
                    'unidad' => 'NIU',
                    'descripcion' => 'Servicio de traslado ' . $paquete->description,
                    'cantidad' => $paquete->cantidad,
                    'mtoValorUnitario' => $mtoValorUnitario,
                    'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
                    'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
                    'porcentajeIgv' => 18,
                    'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'mtoPrecioUnitario' => $paquete->amount,
                ]);
            }
        }
    }
    private function setGuiTrans(Encomienda $encomienda) {
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $correlativo = Ticket::all()->count();
        if ($encomienda->tipo_comprobante == 'TICKET') {
            $ticket = Ticket::create([
                'tipoDoc' => 'TICKET',
                'tipoOperacion' => '0',
                'serie' => '001',
                'correlativo' => $correlativo + 1,
                'fechaEmision' => $encomienda->created_at,
                'formaPago_moneda' => 'PEN',
                'formaPago_tipo' => $encomienda->tipo_pago,
                'tipoMoneda' => 'PEN',
                'company_id' => $company->id,
                'client_id' => $encomienda->customer_id,
                'mtoOperGravadas' => $mtoOperGravadas,
                'mtoIGV' => $igv,
                'totalImpuestos' => $igv,
                'valorVenta' => $mtoOperGravadas,
                'subTotal' => $montoTotalIncIGV,
                'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            ]);
            foreach ($encomienda->paquetes as $paquete) {
                $mtoValorUnitario = round($paquete->amount / 1.18, 2);
                TicketDetail::create([
                    'invoice_id' => $ticket->id,
                    'tipAfeIgv' => '10',
                    'codProducto' => $paquete->id,
                    'unidad' => 'NIU',
                    'descripcion' => 'Servicio de traslado ' . $paquete->description,
                    'cantidad' => $paquete->cantidad,
                    'mtoValorUnitario' => $mtoValorUnitario,
                    'mtoValorVenta' => $mtoValorUnitario * $paquete->cantidad,
                    'mtoBaseIgv' => $mtoValorUnitario * $paquete->cantidad,
                    'porcentajeIgv' => 18,
                    'igv' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'totalImpuestos' => ($paquete->amount - $mtoValorUnitario) * $paquete->cantidad,
                    'mtoPrecioUnitario' => $paquete->amount,
                ]);
            }
        }
    }
}

