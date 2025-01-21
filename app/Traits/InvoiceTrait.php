<?php

namespace App\Traits;

use App\Models\Configuration\Company;
use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\DespatcheDetail;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\InvoiceDetail;
use App\Models\Facturacion\Ticket;
use App\Models\Facturacion\TicketDetail;
use App\Models\Package\Encomienda;
use Luecano\NumeroALetras\NumeroALetras;

trait InvoiceTrait
{
    public function storeInvoce(Encomienda $encomienda)
    {
        if ($encomienda->tipo_comprobante != 'TICKET') {
            $this->setInvoice($encomienda); // Genera factura o boleta
        }
        $this->setTicket($encomienda);   // Genera ticket
        $this->setGuiTrans($encomienda); // Genera guia transportista
    }

    private function setTicket(Encomienda $encomienda)
    {
        $company = Company::first();
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;

        $ticket = Ticket::create([
            'encomienda_id' => $encomienda->id,
            'tipoDoc' => 'TICKET',
            'tipoOperacion' => 'TICKET',
            'serie' => $encomienda->sucursal_remitente->code,
            'correlativo' => Ticket::count() + 1,
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
            $this->createTicketDetail($ticket->id, $paquete);
        }
    }

    private function createTicketDetail($ticketId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        TicketDetail::create([
            'ticket_id' => $ticketId,
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

    private function setInvoice(Encomienda $encomienda)
    {
        $montoTotalIncIGV = $encomienda->paquetes->sum('sub_total');
        $mtoOperGravadas = round($montoTotalIncIGV / 1.18, 2);
        $igv = $montoTotalIncIGV - $mtoOperGravadas;
        $formatter = new NumeroALetras();
        $monto_letras = $formatter->toInvoice($montoTotalIncIGV, 2, 'SOLES');

        $invoiceData = $this->getInvoiceData($encomienda, $montoTotalIncIGV, $mtoOperGravadas, $igv, $monto_letras);
        $invoice = Invoice::create($invoiceData);

        foreach ($encomienda->paquetes as $paquete) {
            $this->createInvoiceDetail($invoice->id, $paquete);
        }
    }

    private function getInvoiceData($encomienda, $montoTotalIncIGV, $mtoOperGravadas, $igv, $monto_letras)
    {
        $company = Company::first();
        $data = [
            'encomienda_id' => $encomienda->id,
            'fechaEmision' => $encomienda->created_at,
            'formaPago_moneda' => 'PEN',
            'formaPago_tipo' => $encomienda->tipo_pago,
            'tipoMoneda' => 'PEN',
            'company_id' => $company->id,
            'client_id' => $encomienda->customer_fact_id,
            'mtoOperGravadas' => $mtoOperGravadas,
            'mtoIGV' => $igv,
            'totalImpuestos' => $igv,
            'valorVenta' => $mtoOperGravadas,
            'subTotal' => $montoTotalIncIGV,
            'mtoImpVenta' => $montoTotalIncIGV, //venta total inc IGV
            'monto_letras' => $monto_letras ?? '',
        ];

        if ($encomienda->tipo_comprobante == 'BOLETA') {
            $data['serie'] = 'B001';
            $data['tipoDoc'] = '03';
            $data['tipoOperacion'] = '0101';
            $data['correlativo'] = Invoice::where('tipoDoc', '03')->count() + 1;
        } else {
            $data['serie'] = 'F001';
            $data['tipoDoc'] = '01';
            $data['correlativo'] = Invoice::where('tipoDoc', '01')->count() + 1;
            if ($montoTotalIncIGV >= 400) {
                $data['tipoOperacion'] = '1001';
                $data['setPercent'] = 12;
                $data['setMount'] = $montoTotalIncIGV * 0.12;
            } else {
                $data['tipoOperacion'] = '0101';
            }
        }

        return $data;
    }

    private function createInvoiceDetail($invoiceId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        InvoiceDetail::create([
            'invoice_id' => $invoiceId,
            'tipAfeIgv' => '10',
            'codProducto' => $paquete->id,
            'unidad' => 'NIU',
            'descripcion' => 'SERVICIO TRASLADO ' . $paquete->description,
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

    private function setGuiTrans(Encomienda $encomienda)
    {
        $company = Company::first();
        $correlativo = Despatche::count() + 1;

        $despatch = Despatche::create([
            'encomienda_id' => $encomienda->id,
            'tipoDoc' => '31',
            'serie' => 'V001',
            'correlativo' => $correlativo,
            'fechaEmision' => $encomienda->created_at,
            'company_id' => $company->id,
            'flete_id' => $encomienda->remitente->id,
            'remitente_id' => $encomienda->remitente->id,
            'destinatario_id' => $encomienda->destinatario->id,
            'codTraslado' => '01',
            'modTraslado' => '02',
            'fecTraslado' => $encomienda->created_at,
            'pesoTotal' => $encomienda->paquetes->sum('peso'),
            'undPesoTotal' => 'KGM',
            'llegada_ubigueo' => '150203',
            'llegada_direccion' => 'Calle falsa 123',
            'partida_ubigueo' => '150101',
            'partida_direccion' => 'Av. Villa Nueva 221',
            'chofer_tipoDoc' => '1',
            'chofer_nroDoc' => '41234567',
            'chofer_licencia' => '0001122020',
            'chofer_nombres' => 'Victor',
            'chofer_apellidos' => 'ABC-123',
            'vehiculo_placa' => 'Arana Flores',
        ]);

        foreach ($encomienda->paquetes as $paquete) {
            $this->createDespatcheDetail($despatch->id, $paquete);
        }
    }

    private function createDespatcheDetail($despatcheId, $paquete)
    {
        $mtoValorUnitario = round($paquete->amount / 1.18, 2);
        DespatcheDetail::create([
            'despatche_id' => $despatcheId,
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
