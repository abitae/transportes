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

    public function getInvoce($invoice): \Greenter\Model\Sale\Invoice
    {
        $invoice = new \Greenter\Model\Sale\Invoice();

        $invoice->setUblVersion('2.1');
        $invoice->setFecVencimiento(new \DateTime());
        $invoice->setTipoOperacion('0101'); //CATALOGO 51
        $invoice->setTipoDoc('01'); //CATALOGO 01 
        $invoice->setSerie('F001');
        $invoice->setCorrelativo('1');
        $invoice->setFechaEmision(new \DateTime());
        $invoice->setFormaPago(new FormaPagoContado()); // new FormaPagoCredito(236)

        $invoice->setCuotas([]);


        $invoice->setTipoMoneda('PEN');

        $invoice->setCompany(new \Greenter\Model\Company\Company());
        $invoice->setClient(new \Greenter\Model\Client\Client());

        $invoice->setMtoOperGravadas(200);
        $invoice->setMtoOperExoneradas(100);
        $invoice->setMtoIGV(36);
        $invoice->setTotalImpuestos(36);
        $invoice->setValorVenta(300);
        $invoice->setSubTotal(336);
        $invoice->setMtoImpVenta(336);
        $invoice->setDetails([]);
        $invoice->setLegends([]);

        //Detraccion
        $invoice->setDetraccion(null);


        $invoice->setSumOtrosCargos(0);
        $invoice->setMtoOperInafectas(0);
        $invoice->setMtoOperExportacion(0);
        $invoice->setMtoOperGratuitas(0);
        $invoice->setMtoIGVGratuitas(0);
        $invoice->setMtoBaseIvap(0);
        $invoice->setMtoIvap(0);
        $invoice->setMtoBaseIsc(0);
        $invoice->setMtoBaseOth(0);
        $invoice->setMtoOtrosTributos(0);
        $invoice->setIcbper(0);
        $invoice->setRedondeo(0);
        $invoice->setGuias([]);
        $invoice->setRelDocs([]);
        $invoice->setCompra(null);
        
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
        
        $invoice->setSeller(null);

        $invoice->setObservacion('');                                         // Observaciones
        $invoice->setDireccionEntrega(new \Greenter\Model\Company\Address()); // Direccion de entrega

        return $invoice;
    }
    public function getCompany(): \Greenter\Model\Company\Company
    {
        $company = new \Greenter\Model\Company\Company();
        $company->setRuc('20123456789');
        $company->setRazonSocial('ACME SAC');
        $company->setNombreComercial('ACME');
        $company->setAddress(new \Greenter\Model\Company\Address());
        $company->setEmail('');
        $company->setTelephone('');
        return $company;
    }
    public function getClient(): \Greenter\Model\Client\Client
    {
        $client = new \Greenter\Model\Client\Client();
        $client->setTipoDoc('6');
        $client->setNumDoc('20123456789');
        $client->setRznSocial('EMPRESA SAC');
        $client->setAddress(new \Greenter\Model\Company\Address());
        $client->setEmail('');
        $client->setTelephone('');
        return $client;
    }
    public function getAddress(): \Greenter\Model\Company\Address
    {
        $address = new \Greenter\Model\Company\Address();
        $address->setUbigueo('150101');
        $address->setCodigoPais('PE');
        $address->setDepartamento('LIMA');
        $address->setProvincia('LIMA');
        $address->setDistrito('LIMA');
        $address->setUrbanizacion('');
        $address->setDireccion('AV. LIMA 123');
        $address->setCodLocal('0000');
        return $address;
    }
    public function getDetails(): array
    {
        $details = [];
        $item    = new \Greenter\Model\Sale\SaleDetail();
        $item->setCodProducto('P001');
        $item->setUnidad('NIU');
        $item->setDescripcion('PRODUCTO 1');
        $item->setCantidad(2);
        $item->setMtoValorUnitario(50);
        $item->setMtoValorVenta(100);
        $item->setMtoBaseIgv(100);
        $item->setPorcentajeIgv(18.00);
        $item->setCodProdSunat('');
        $item->setCodProdGS1('');
        $item->setIgv(18);
        $item->setTipAfeIgv('10'); // Catalog: 07
        $item->setTotalImpuestos(18);
        $item->setMtoPrecioUnitario(56);

        $item->setCargos([]);
        $item->setDescuentos([]);
        $item->setDescuento(0);
        $item->setMtoBaseIsc(0);
        $item->setPorcentajeIsc(0);
        $item->setIsc(0);
        $item->setTipSisIsc('');
        $item->setMtoBaseOth(0);
        $item->setPorcentajeOth(0);
        $item->setOtroTributo(0);
        $item->setIcbper(0);
        $item->setFactorIcbper(0);
        $item->setMtoValorGratuito(0);
        $item->setAtributos([]);

        $details[] = $item;
        return $details;
    }
    public function getLegends(): array
    {
        $legends = [];
        $legend  = new \Greenter\Model\Sale\Legend();

        $legend->setCode('1000');
        $legend->setValue('SON CIEN CON 00/100 SOLES');

        $legends[] = $legend;

        $legend->setCode('1000');
        $legend->setValue('SON CIEN CON 00/100 SOLES');

        $legends[] = $legend;
        return $legends;
    }
    public function getDetraccion(): \Greenter\Model\Sale\Detraction
    {
        $detraction = new \Greenter\Model\Sale\Detraction();
        $detraction->setCodBienDetraccion('014'); // catalog. 54
        $detraction->setCodMedioPago('001');      // catalog. 59
        $detraction->setCtaBanco('0004-3342343243');
        $detraction->setPercent(4.00);
        $detraction->setMount(37.76);
        return $detraction;
    }
    public function getNote(): \Greenter\Model\Sale\Note
    {
        $note = new \Greenter\Model\Sale\Note();
        $note->setUblVersion('2.1');
        $note->setTipoDoc('07');
        $note->setSerie('FF01');
        $note->setCorrelativo('123');
        $note->setFechaEmision(new \DateTime());
        $note->setTipDocAfectado('01');// Tipo Doc: Factura
        $note->setNumDocfectado('F001-1'); // Factura: Serie-Correlativo
        $note->setCodMotivo('01'); // Catalogo 09
        $note->setDesMotivo('Anulacion de la operacion');

        $note->setTipoMoneda('PEN');

        $note->setCompany(new \Greenter\Model\Company\Company());
        $note->setClient(new \Greenter\Model\Client\Client());
        $note->setMtoOperGravadas(100);
        $note->setMtoOperExoneradas(0);
        $note->setMtoOperInafectas(0);
        $note->setMtoOperExportacion(0);
        $note->setMtoIGV(18);
        $note->setMtoISC(0);
        $note->setMtoOtrosTributos(0);
        $note->setMtoImpVenta(118);
        $note->setDetails([]);
        $note->setLegends([]);
        $note->setGuias([]);
        $note->setRelDocs([]);
        $note->setCompra(null);

        return $note;
    }
    public function Despatch() : \Greenter\Model\Despatch\Despatch 
    {
        $despatch = new \Greenter\Model\Despatch\Despatch();
        $despatch->setTipoDoc('09');
        $despatch->setSerie('T001');
        $despatch->setCorrelativo('1');
        $despatch->setFechaEmision(new \DateTime());
        $despatch->setCompany($this->getGRECompany());
        $despatch->setDestinatario(new \Greenter\Model\Client\Client());
        $despatch->setDetails([]);
        return $despatch;
    }
    public function getGRECompany(): \Greenter\Model\Company\Company
    {
        $company = new \Greenter\Model\Company\Company();
        $company->setRuc('20123456789');
        $company->setRazonSocial('ACME SAC');
        $company->setNombreComercial('ACME');
        $company->setAddress(new \Greenter\Model\Company\Address());
        $company->setEmail('');
        $company->setTelephone('');
        return $company;
    }

}
