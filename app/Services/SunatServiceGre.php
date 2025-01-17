<?php
namespace App\Services;

use App\Models\Facturacion\Despatche;
use DateTime;
use Greenter\Api;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\AdditionalDoc;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Driver;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Despatch\Vehicle;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Support\Facades\Storage;

class SunatServiceGre
{
    //Api de Guias de Remicion/Transportista
    public function getSeeApi($company)
    {
        $api = new Api(
            $company->production ?
            [
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

    //Guias de Transportista
    public function getDespatch(Despatche $despatche)
    {

        $pagaflete = new Client();
        $pagaflete->setTipoDoc("6")
            ->setNumDoc("10436493903")
            ->setRznSocial("Abel Arana");
        $item = new AdditionalDoc();
        $item->setTipo("01")
            ->setTipoDesc("Factura")
            ->setNro("F001-00000007")
            ->setEmisor("1043649390");
        $relDoc[] = $item;
        $destinatario=new Client();
        $destinatario->setTipoDoc('6')
        ->setNumDoc('10436493903')
        ->setRznSocial('Abel Arana');
        return (new Despatch)
            ->setVersion('2022')
            ->setTipoDoc('31')
            ->setSerie('V001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime($despatche->fechaEmision ?? null))
            ->setPagaFlete($pagaflete) //*******  */
            ->setCompany($this->getGRECompany())
            ->setDestinatario($destinatario)
            ->setEnvio($this->getEnvio($despatche))
            ->setObservacion('glosa')
            ->setAddDocs($relDoc)
            ->setDetails($this->getDespatchDetails($despatche['details']))
        ;
    }
    public function getFlete($data)
    {
       
            $flete = (new Client())
                ->setTipoDoc('6' ?? null)
                ->setNumDoc("10436493903" ?? null)
                ->setRznSocial("Abel Arana" ?? null);
        
        

        return $flete;
    }
    public function getGRECompany(): Company
    {
        return (new Company())
            ->setRuc('10436493903')
            ->setRazonSocial('Abel Arana');

    }
    public function getCompany($data)
    {
        $company = (new Company())
            ->setRuc($data['ruc'] ?? null)
            ->setRazonSocial($data['razonSocial'] ?? null)
            ->setNombreComercial($data['nombreComercial'] ?? null)
            ->setAddress($this->getAddress($data['address']));
        return $company;
    }
    public function getAddress($data)
    {
        // Emisor
        $address = (new Address())
            ->setUbigueo($data['ubigueo'])
            ->setDepartamento($data['departamento'])
            ->setProvincia($data['provincia'])
            ->setDistrito($data['distrito'])
            ->setUrbanizacion($data['urbanizacion'])
            ->setDireccion($data['direccion'])
            ->setCodLocal($data['codLocal']); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        return $address;
    }
    public function getClient($data)
    {
        // Cliente
        $client = (new Client())
            ->setTipoDoc($data['tipoDoc'] ?? null)
            ->setNumDoc($data['numDoc'] ?? null)
            ->setRznSocial($data['rznSocial'] ?? null);
        return $client;
    }
    public function getEnvio($data)
    {
        //dd($data);
        $indicadores[] = "SUNAT_Envio_IndicadorPagadorFlete_Remitente";
        $transp = new Transportist();
        $transp->setTipoDoc('6')
            ->setNumDoc("20541528092")
            ->setRznSocial("Abel Arana")
            ->setNroMtc("123456");
        $remitente = new Client();
        $remitente->setTipoDoc("6")
            ->setNumDoc("10436493901")
            ->setRznSocial("Abel Arana");
        $shipment = (new Shipment)
            ->setCodTraslado('01')                                       //catalogo 20 sunat
            ->setModTraslado('02')                                       //catalogo 18 sunat
            ->setFecTraslado(new DateTime($data['fecTraslado'] ?? null)) // Zona horaria: Lima
            ->setPesoTotal($data->pesoTotal ?? null)
            ->setUndPesoTotal($data->undPesoTotal ?? null) //catalogo 02 sunat
            ->setTransportista($transp)
            ->setVehiculo($this->getVehiculo($data ?? null))
            ->setChoferes($this->getChoferes($data['choferes']) ?? null)
            ->setIndicador($indicadores)
            ->setLlegada(new Direction($data->llegada_ubigueo, $data->llegada_direccion))
            ->setPartida(new Direction($data->partida_ubigueo, $data->partida_direccion))
            ->setRemitente($remitente);

        return $shipment;
    }
    public function getTransportista($data)
    {
        return (new Transportist())
            ->setTipoDoc($data['ruc'] ?? null)
            ->setNumDoc($data['numDoc'] ?? null)
            ->setRznSocial($data['rznSocial'] ?? null)
            ->setNroMtc($data['nroMtc'] ?? null);
    }
    public function getVehiculo($data)
    {
        //dd($data->vehiculo_placa);

        $secundarios = [];
        return (new Vehicle())
            ->setPlaca('ABC123' ?? null)
            ->setSecundarios($secundarios);
    }
    public function getChoferes($choferes)
    {
        $choferes  = collect($choferes);
        $drivers   = [];
        $drivers[] = (new Driver)
            ->setTipo('Principal')
            ->setTipoDoc('1' ?? null)
            ->setNroDoc('43649390' ?? null)
            ->setLicencia('A43649390' ?? null)
            ->setNombres('Abel Arana' ?? null)
            ->setApellidos('Arana Cortez' ?? null);
        foreach ($choferes->slice(1) as $item) {
            $drivers[] = (new Driver)
                ->setTipo('Secundario')
                ->setTipoDoc($item['tipoDoc'] ?? null)
                ->setNroDoc($item['nroDoc'] ?? null)
                ->setLicencia($item['licencia'] ?? null)
                ->setNombres($item['nombres'] ?? null)
                ->setApellidos($item['apellidos'] ?? null);
        }
        //dd($drivers);
        return $drivers;
    }
    public function getDespatchDetails($details)
    {
        //dd($details);
        $green_details = [];
        foreach ($details as $data) {
            $green_details[] = (new DespatchDetail())
                ->setCantidad($data->cantidad ?? null)
                ->setUnidad($data->unidad ?? null) // Unidad - Catalog. 03
                ->setDescripcion($data->descripcion ?? null)
                ->setCodigo($data->codProducto ?? null);
        }
        //dd($green_details);
        return $green_details;
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
        // Guardamos el CDR
        //file_put_contents('R-' . $invoice->getName() . '.zip', $result->getCdrZip());

        return $response;
    }
    public function getSee($company)
    {
        $see = new See();
        $see->setCertificate(Storage::get($company->cert_path));
        $see->setService($company->production ? SunatEndpoints::FE_PRODUCCION : SunatEndpoints::FE_BETA);
        $see->setClaveSOL($company->ruc, $company->sol_user, $company->sol_pass);
        return $see;
    }

}
