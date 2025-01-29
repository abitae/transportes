<?php
namespace App\Services;

use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
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

    public function getSeeApi($company)
    {
        $api = new Api(
            $company->production ? [
                'auth' => 'https://api-seguridad.sunat.gob.pe/v1',
                'cpe'  => 'https://api-cpe.sunat.gob.pe/v1',
            ] : [
                'auth' => 'https://gre-test.nubefact.com/v1',
                'cpe'  => 'https://gre-test.nubefact.com/v1',
            ]
        );
        $api->setBuilderOptions([
            'strict_variables' => true,
            'optimization'     => 0,
            'debug'            => true,
            'cache'            => false,
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

    public function getInvoce($data2) //: \Greenter\Model\Sale\Invoice
    {
        $data = [
            'ublVersion'         => '2.1',
            'fecVencimiento'     => '2023-12-31',
            'tipoOperacion'      => '0101',
            'tipoDoc'            => '01',
            'serie'              => 'F001',
            'correlativo'        => '1',
            'fechaEmision'       => '2023-10-01',
            'formaPago'          => 'Contado',
            'mtoCredito'         => 0,
            'tipoMoneda'         => 'PEN',
            'company'            => [
                'ruc'             => '20123456789',
                'razonSocial'     => 'ACME SAC',
                'nombreComercial' => 'ACME',
                'address'         => [
                    'ubigueo'      => '150101',
                    'codigoPais'   => 'PE',
                    'departamento' => 'LIMA',
                    'provincia'    => 'LIMA',
                    'distrito'     => 'LIMA',
                    'direccion'    => 'AV LIMA 123',
                    'codLocal'     => '0000',
                ],
            ],
            'client'             => [
                'tipoDoc'   => '6',
                'numDoc'    => '10436493903',
                'rznSocial' => 'Abel Arana',
                'address'   => [
                    'ubigueo'      => '150101',
                    'codigoPais'   => 'PE',
                    'departamento' => 'LIMA',
                    'provincia'    => 'LIMA',
                    'distrito'     => 'LIMA',
                    'direccion'    => 'AV ITALIA 456',
                    'codLocal'     => '0001',
                ],
            ],
            'mtoOperGravadas'    => 1000.00,
            'mtoOperExoneradas'  => 0.00,
            'mtoOperInafecto'    => 0.00,
            'mtoOperExportacion' => 0.00,
            'mtoOperGratuitas'   => 0.00,
            'mtoIGV'             => 180.00,
            'mtoIGVGratuitas'    => 0.00,
            'icbper'             => 0.00,
            'totalImpuestos'     => 180.00,
            'valorVenta'         => 1000.00,
            'subTotal'           => 1180.00,
            'mtoImpVenta'        => 1180.00,
            'redondeo'           => 0.00,
            'detraccion'         => [
                'codBienDetraccion' => '025',
                'codMedioPago'      => '001',
                'ctaBanco'          => '123456789012',
                'percent'           => 4.00,
                'mount'             => 47.20,
            ],
            'details'            => [
                [
                    'tipAfeIgv'         => '10',
                    'codProducto'       => 'P001',
                    'unidad'            => 'NIU',
                    'descripcion'       => 'Producto 1',
                    'cantidad'          => 1,
                    'mtoValorUnitario'  => 1000.00,
                    'mtoValorVenta'     => 1000.00,
                    'mtoBaseIgv'        => 1000.00,
                    'porcentajeIgv'     => 18.00,
                    'igv'               => 180.00,
                    'factorIcbper'      => 0.00,
                    'icbper'            => 0.00,
                    'totalImpuestos'    => 180.00,
                    'mtoPrecioUnitario' => 1180.00,
                ],
            ],
            'legents'            => [
                [
                    'code'  => '1000',
                    'value' => 'SON MIL CON 00/100 SOLES',
                ],
            ],
            'observacion'        => 'Observación de prueba',
            'direccionEntrega'   => [
                'ubigueo'      => '150101',
                'codigoPais'   => 'PE',
                'departamento' => 'LIMA',
                'provincia'    => 'LIMA',
                'distrito'     => 'LIMA',
                'direccion'    => 'AV LIMA 123',
                'codLocal'     => '0000',
            ],
        ];
        $data = (object) $data;
        //return $data;
        $invoice = new \Greenter\Model\Sale\Invoice();
        $invoice->setUblVersion($data->ublVersion ?? '2.1');
        $invoice->setFecVencimiento(new DateTime($data->fecVencimiento) ?? null);
        $invoice->setTipoOperacion($data->tipoOperacion ?? '0101');
        $invoice->setTipoDoc($data->tipoDoc ?? '01');
        $invoice->setSerie($data->serie ?? 'F001');
        $invoice->setCorrelativo($data->correlativo ?? '1');
        $invoice->setFechaEmision(new DateTime($data->fechaEmision) ?? null);
        $invoice->setFormaPago($data->formaPago == 'Contado' ? new FormaPagoContado() : new FormaPagoCredito($data->mtoCredito, 'PEN'));
        $invoice->setTipoMoneda($data->tipoMoneda ?? 'PEN');
        $invoice->setCompany($this->getCompany((object) $data->company));
        $invoice->setClient($this->getClient((object) $data->client));

        $invoice->setMtoOperGravadas($data->mtoOperGravadas);
        $invoice->setMtoOperExoneradas($data->mtoOperExoneradas);
        $invoice->setMtoOperInafectas($data->mtoOperInafecto);
        $invoice->setMtoOperExportacion($data->mtoOperExportacion);
        $invoice->setMtoOperGratuitas($data->mtoOperGratuitas);
        $invoice->setMtoIGV($data->mtoIGV);
        $invoice->setMtoIGVGratuitas($data->mtoIGVGratuitas);
        $invoice->setIcbper($data->icbper);
        $invoice->setTotalImpuestos($data->totalImpuestos);
        $invoice->setValorVenta($data->valorVenta);
        $invoice->setSubTotal($data->subTotal);
        $invoice->setMtoImpVenta($data->mtoImpVenta);
        $invoice->setRedondeo($data->redondeo);
        $invoice->setDetraccion($this->getDetraccion((object)$data->detraccion));
        $invoice->setDetails($this->getDetails((object) $data->details));
        $invoice->setLegends($this->getLegends((object) $data->legents));
        $invoice->setObservacion($data->observacion ?? null);
        $invoice->setDireccionEntrega($this->getAddress((object) $data->direccionEntrega));

        return $invoice;
    }

    public function getCompany($company): \Greenter\Model\Company\Company
    {
        //dd($company);
        return (new \Greenter\Model\Company\Company())
            ->setRuc($company->ruc)
            ->setRazonSocial($company->razonSocial)
            ->setNombreComercial($company->nombreComercial)
            ->setAddress($this->getAddress((object) $company->address));
    }

    public function getClient($client): \Greenter\Model\Client\Client
    {
        return (new \Greenter\Model\Client\Client())
            ->setTipoDoc($client->tipoDoc)
            ->setNumDoc($client->numDoc)
            ->setRznSocial($client->rznSocial)
            ->setAddress($this->getAddress((object) $client->address));
    }

    public function getAddress($address): \Greenter\Model\Company\Address
    {
        return (new \Greenter\Model\Company\Address())
            ->setUbigueo($address->ubigueo)
            ->setCodigoPais($address->codigoPais)
            ->setDepartamento($address->departamento)
            ->setProvincia($address->provincia)
            ->setDistrito($address->distrito)
            ->setDireccion($address->direccion)
            ->setCodLocal($address->codLocal);
    }

    public function getDetails($details): array
    {
        //dd((object)($details));
        $items = [];
        foreach ($details as $detail) {
            $detail = (object) $detail;
            $item   = (new \Greenter\Model\Sale\SaleDetail())
                ->setTipAfeIgv($detail->tipAfeIgv)
                ->setCodProducto($detail->codProducto)
                ->setUnidad($detail->unidad)
                ->setDescripcion($detail->descripcion)
                ->setCantidad($detail->cantidad)
                ->setMtoValorUnitario($detail->mtoValorUnitario)
                ->setMtoValorVenta($detail->mtoValorVenta)
                ->setMtoBaseIgv($detail->mtoBaseIgv)
                ->setPorcentajeIgv($detail->porcentajeIgv)
                ->setIgv($detail->igv)
                ->setFactorIcbper($detail->factorIcbper)
                ->setIcbper($detail->icbper)
                ->setTotalImpuestos($detail->totalImpuestos)
                ->setMtoPrecioUnitario($detail->mtoPrecioUnitario);
            $items[] = $item;

        }
        return $items;
    }

    public function getLegends($legends): array
    {
        $items = [];
        foreach ($legends as $legend) {
            $legend = (object) $legend;
            $item   = (new \Greenter\Model\Sale\Legend())
                ->setCode($legend->code)
                ->setValue($legend->value);
            $items[] = $item;
        }
        return $items;
    }

    public function getDetraccion($detraccion): \Greenter\Model\Sale\Detraction
    {
        return (new \Greenter\Model\Sale\Detraction())
            ->setCodBienDetraccion($detraccion->codBienDetraccion)
            ->setCodMedioPago($detraccion->codMedioPago)
            ->setCtaBanco($detraccion->ctaBanco)
            ->setPercent($detraccion->percent)
            ->setMount($detraccion->mount);
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
        $remitente   = (new Client())
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
        if (! $response['success']) {
            $response['error'] = [
                'code'    => $result->getError()->getCode(),
                'message' => $result->getError()->getMessage(),
            ];
            return $response;
        }

        $cdr = $result->getCdrResponse();

        $response['cdrResponse'] = [
            'code'        => (int) $cdr->getCode(),
            'description' => $cdr->getDescription(),
            'notes'       => $cdr->getNotes(),
            'cdrZip'      => base64_encode($result->getCdrZip()),
        ];

        return $response;
    }
}
