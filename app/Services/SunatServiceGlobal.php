<?php
namespace App\Services;

use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Storage;

class SunatServiceGlobal
{
    public function getSee($company)
    {
        $see = new See();
        $see->setCertificate(Storage::get($company->cert_path));
        $see->setService($company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);
        return $see;
    }

    public function getInvoce($invoice)
    {
        $invoice = new \Greenter\Model\Sale\Invoice();
        $invoice->setTipoOperacion('0101');
        $invoice->setFecVencimiento(new \DateTime());
        $invoice->setSumDsctoGlobal(0);
        $invoice->setMtoDescuentos(0);
        $invoice->setSumOtrosDescuentos(0);
        $invoice->setDescuentos([]);
        $invoice->setCargos([]);
        $invoice->setMtoCargos(0);
        $invoice->setTotalAnticipos(0);
        $invoice->setPerception(null);
        $invoice->setGuiaEmbebida(null);
        $invoice->setAnticipos([]);
        $invoice->setDetraccion(null);
        $invoice->setSeller(null);
        $invoice->setValorVenta(0);
        $invoice->setSubTotal(0);
        $invoice->setObservacion(''); // Observaciones
        $invoice->setDireccionEntrega(new \Greenter\Model\Company\Address()); // Direccion de entrega
       
        $invoice->setUblVersion('2.1');
        $invoice->setTipoDoc('01');
        $invoice->setSerie('F001');
        $invoice->setCorrelativo('1');
        $invoice->setFechaEmision(new \DateTime());
        $invoice->setCompany(new \Greenter\Model\Company\Company());
        $invoice->setClient(new \Greenter\Model\Client\Client());
        $invoice->setTipoMoneda('PEN');
        $invoice->setSumOtrosCargos(0);
        $invoice->setMtoOperGravadas(0);
        $invoice->setMtoOperInafectas(0);
        $invoice->setMtoOperExoneradas(0);
        $invoice->setMtoOperExportacion(0);
        $invoice->setMtoOperGratuitas(0);
        $invoice->setMtoIGVGratuitas(0);
        $invoice->setMtoIGV(0);
        $invoice->setMtoBaseIvap(0);
        $invoice->setMtoIvap(0);
        $invoice->setMtoBaseIsc(0);
        $invoice->setMtoBaseOth(0);
        $invoice->setMtoOtrosTributos(0);
        $invoice->setIcbper(0);
        $invoice->setTotalImpuestos(0);
        $invoice->setRedondeo(0);
        $invoice->setMtoImpVenta(0);
        $invoice->setDetails([]);
        $invoice->setLegends([]);
        $invoice->setGuias([]);
        $invoice->setRelDocs([]);
        $invoice->setCompra(null);
        $invoice->setFormaPago(new \Greenter\Model\Sale\PaymentTerms);
        $invoice->setCuotas([]);
    }
}