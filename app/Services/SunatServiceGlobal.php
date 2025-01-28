<?php

namespace App\Services;

use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;

use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Date;
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

    public function getSeeApi($company)
    {
        $api = new Api(
            $company->production ? [
                'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
                'cpe' => 'https://api-cpe.sunat.gob.pe/v1',
            ] : [
                'auth' => 'https://gre-test.nubefact.com/v1',
                'cpe' => 'https://gre-test.nubefact.com/v1',
            ]
        );
        $api->setBuilderOptions([
            'strict_variables' => true,
            'optimization' => 0,
            'debug' => true,
            'cache' => false,
        ])->setApiCredentials(
            $company->production ? $company->client_id : "test-85e5b0ae-255c-4891-a595-0b98c65c9854",
            $company->production ? $company->client_secret : "test-Hty/M6QshYvPgItX2P0+Kw=="
        )->setClaveSOL(
            $company->ruc,
            $company->production ? $company->sol_user : 'MODDATOS',
            $company->production ? $company->sol_pass : 'MODDATOS'
        )->setCertificate(
            Storage::get($company->cert_path)
        );
        return $api;
    }

    public function getInvoce($data): \Greenter\Model\Sale\Invoice
    {

        $invoice = new \Greenter\Model\Sale\Invoice();
        $invoice->setUblVersion($data->ublVersion ?? '2.1')
            ->setFecVencimiento(new DateTime($data->fecVencimiento) ?? null)
            ->setTipoOperacion($data->tipoOperacion ?? '0101')
            ->setTipoDoc($data->tipoDoc ?? '01')
            ->setSerie($data->serie ?? 'F001')
            ->setCorrelativo($data->correlativo ?? '1')
            ->setFechaEmision(new DateTime($$data->fechaEmision) ?? null)
            ->setFormaPago($data->formaPago == 'Contado' ? new FormaPagoContado() : new FormaPagoCredito($data->mtoCredito, 'PEN'))
            ->setTipoMoneda($data->tipoMoneda ?? 'PEN')
            ->setCompany($this->getCompany())
            ->setClient($this->getClient())
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(100)
            ->setMtoOperInafectas(0)
            ->setMtoOperExportacion(0)
            ->setMtoOperGratuitas(0)
            ->setMtoIGV(36)
            ->setMtoIGVGratuitas(0)
            ->setIcbper(0)
            ->setTotalImpuestos(36)
            ->setValorVenta(300)
            ->setSubTotal(336)
            ->setMtoImpVenta(336)
            ->setRedondeo(0)
            ->setDetails($this->getDetails($data->details))
            ->setLegends([])
            ->setObservacion('')
            ->setDireccionEntrega(new \Greenter\Model\Company\Address());

        return $invoice;
    }

    public function getCompany(): \Greenter\Model\Company\Company
    {
        return (new \Greenter\Model\Company\Company())
            ->setRuc('20123456789')
            ->setRazonSocial('ACME SAC')
            ->setNombreComercial('ACME')
            ->setAddress(new \Greenter\Model\Company\Address());
    }

    public function getClient(): \Greenter\Model\Client\Client
    {
        return (new \Greenter\Model\Client\Client())
            ->setTipoDoc('6')
            ->setNumDoc('20123456789')
            ->setRznSocial('EMPRESA SAC')
            ->setAddress(new \Greenter\Model\Company\Address());
    }

    public function getAddress(): \Greenter\Model\Company\Address
    {
        return (new \Greenter\Model\Company\Address())
            ->setUbigueo('150101')
            ->setCodigoPais('PE')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setDireccion('AV. LIMA 123')
            ->setCodLocal('0000');
    }

    public function getDetails(): array
    {
        $item = (new \Greenter\Model\Sale\SaleDetail())
            ->setTipAfeIgv('10')
            ->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setDescripcion('PRODUCTO 1')
            ->setCantidad(2)
            ->setMtoValorUnitario(50)
            ->setMtoValorVenta(100)
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00)
            ->setIgv(18)
            ->setFactorIcbper(0)
            ->setIcbper(0)
            ->setTotalImpuestos(18)
            ->setMtoPrecioUnitario(56);

        return [$item];
    }

    public function getLegends(): array
    {
        $legend = (new \Greenter\Model\Sale\Legend())
            ->setCode('1000')
            ->setValue('SON CIEN CON 00/100 SOLES');

        return [$legend];
    }

    public function getDetraccion(): \Greenter\Model\Sale\Detraction
    {
        return (new \Greenter\Model\Sale\Detraction())
            ->setCodBienDetraccion('014')
            ->setCodMedioPago('001')
            ->setCtaBanco('0004-3342343243')
            ->setPercent(4.00)
            ->setMount(37.76);
    }

    public function getNote(): \Greenter\Model\Sale\Note
    {
        return (new \Greenter\Model\Sale\Note())
            ->setUblVersion('2.1')
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-1')
            ->setCodMotivo('01')
            ->setDesMotivo('Anulacion de la operacion')
            ->setTipoMoneda('PEN')
            ->setCompany(new \Greenter\Model\Company\Company())
            ->setClient(new \Greenter\Model\Client\Client())
            ->setMtoOperGravadas(100)
            ->setMtoIGV(18)
            ->setMtoImpVenta(118)
            ->setDetails([])
            ->setLegends([]);
    }

    public function Despatch(): \Greenter\Model\Despatch\Despatch
    {
        return (new \Greenter\Model\Despatch\Despatch())
            ->setVersion('2022')
            ->setTipoDoc('09')
            ->setSerie('T001')
            ->setCorrelativo('1')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getGRECompany())
            ->setDestinatario(new \Greenter\Model\Client\Client())
            ->setEnvio(new \Greenter\Model\Despatch\Shipment())
            ->setDetails($this->getDespatchDetail());
    }

    public function getGRECompany(): \Greenter\Model\Company\Company
    {
        return (new \Greenter\Model\Company\Company())
            ->setRuc('20123456789')
            ->setRazonSocial('ACME SAC');
    }

    public function getEnvio(): \Greenter\Model\Despatch\Shipment
    {
        return (new \Greenter\Model\Despatch\Shipment())
            ->setModTraslado('01')
            ->setCodTraslado('01')
            ->setFecTraslado(new \DateTime())
            ->setPesoTotal(10)
            ->setUndPesoTotal('KGM')
            ->setLlegada(new \Greenter\Model\Despatch\Direction('150101', 'AV LIMA'))
            ->setPartida(new \Greenter\Model\Despatch\Direction('150203', 'AV ITALIA'))
            ->setTransportista($this->getTransportista());
    }

    public function getTransportista(): \Greenter\Model\Despatch\Transportist
    {
        return (new \Greenter\Model\Despatch\Transportist())
            ->setTipoDoc('6')
            ->setNumDoc('20123456789')
            ->setRznSocial('EMPRESA SAC')
            ->setNroMtc('0001');
    }

    public function getDespatchDetail(): array
    {
        $item = (new \Greenter\Model\Despatch\DespatchDetail())
            ->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion('PROD 1')
            ->setCodigo('PROD1');

        return [$item];
    }

    public function getDespatchTransport(): \Greenter\Model\Despatch\Despatch
    {
        $pagaflete = (new Client())
            ->setTipoDoc("6")
            ->setNumDoc("10436493903")
            ->setRznSocial("Abel Arana");

        $destinatario = (new Client())
            ->setTipoDoc('6')
            ->setNumDoc('10436493903')
            ->setRznSocial('Abel Arana');

        $item = (new \Greenter\Model\Despatch\AdditionalDoc())
            ->setTipo("01")
            ->setTipoDesc("Factura")
            ->setNro("F001-00000007")
            ->setEmisor("1043649390");
        $despatch = new \Greenter\Model\Despatch\Despatch();
        
        $despatch->setVersion('2022');
        $despatch->setTipoDoc('31');
        $despatch->setSerie('V001');
        $despatch->setCorrelativo('1');
        $despatch->setFechaEmision(new \DateTime());
        $despatch->setPagaFlete($pagaflete);
        $despatch->setCompany($this->getGRECompany());
        $despatch->setDestinatario($destinatario);
        $despatch->setEnvio(new \Greenter\Model\Despatch\Shipment());
        $despatch->setObservacion('OBSERVACION');
        $despatch->setAddDocs([$item]);
        $despatch->setDetails($this->getDespatchDetail());
        return $despatch;
    }

    public function getDespatchEnvio(): \Greenter\Model\Despatch\Shipment
    {
        $indicadores = ["SUNAT_Envio_IndicadorPagadorFlete_Remitente"];
        $remitente = (new Client())
            ->setTipoDoc("6")
            ->setNumDoc("10436493901")
            ->setRznSocial("Abel Arana");

        $shipment = new \Greenter\Model\Despatch\Shipment();
        $shipment->setModTraslado('01');
        $shipment->setCodTraslado('01');
        $shipment->setFecTraslado(new \DateTime());
        $shipment->setPesoTotal(10);
        $shipment->setUndPesoTotal('KGM');
        $shipment->setLlegada(new \Greenter\Model\Despatch\Direction('150101', 'AV LIMA'));
        $shipment->setPartida(new \Greenter\Model\Despatch\Direction('150203', 'AV ITALIA'));
        $shipment->setTransportista($this->getTransportista());
        $shipment->setVehiculo($this->getVehiculos());
        $shipment->setChoferes($this->getChoferes());
        $shipment->setIndicador($indicadores);
        $shipment->setRemitente($remitente);
        return $shipment;
    }

    public function getVehiculos(): \Greenter\Model\Despatch\Vehicle
    {
        $vehiculos = collect([
            ['placa' => 'A1'],
            ['placa' => 'A2'],
            ['placa' => 'A3'],
        ]);

        $secundarios = $vehiculos->slice(1)->map(function ($item) {
            return (new \Greenter\Model\Despatch\Vehicle())->setPlaca($item['placa']);
        })->toArray();

        return (new \Greenter\Model\Despatch\Vehicle())
            ->setPlaca($vehiculos->first()['placa'])
            ->setSecundarios($secundarios);
    }

    public function getChoferes(): array
    {
        $choferes = collect([
            ['tipoDoc' => '1', 'numDoc' => '12345678', 'nombre' => 'JUAN PEREZ'],
            ['tipoDoc' => '1', 'numDoc' => '87654321', 'nombre' => 'MARIA PEREZ'],
        ]);

        $drivers = $choferes->map(function ($item, $key) {
            return (new \Greenter\Model\Despatch\Driver())
                ->setTipo($key === 0 ? 'Principal' : 'Secundario')
                ->setTipoDoc($item['tipoDoc'])
                ->setNroDoc($item['numDoc'])
                ->setNombres($item['nombre']);
        })->toArray();

        return $drivers;
    }

    public function sunatResponse($result)
    {
        $response['success'] = $result->isSuccess();
        if (!$response['success']) {
            $response['error'] = [
                'code' => $result->getError()->getCode(),
                'message' => $result->getError()->getMessage()
            ];
            return $response;
        }

        $cdr = $result->getCdrResponse();

        $response['cdrResponse'] = [
            'code' => (int)$cdr->getCode(),
            'description' => $cdr->getDescription(),
            'notes' => $cdr->getNotes(),
            'cdrZip' => base64_encode($result->getCdrZip())
        ];

        return $response;
    }
}
