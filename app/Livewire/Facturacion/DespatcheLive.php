<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Despatche;
use App\Services\SunatServiceGre;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DespatcheLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'Guia de Transportista';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage = 10;
    public function render()
    {
        $despaches = Despatche::latest()->paginate($this->perPage);
        return view('livewire.facturacion.despatche-live', compact('despaches'));
    }
    public function xmlGenerate(Despatche $despatche)
    {
        $company = $despatche->company;
        //dd($company);
        $sunat = new SunatServiceGre();
        //creo la configuracion see
        $api = $sunat->getSee($company);
        //dd($see);
        $despatch = $sunat->getDespatch($despatche);
        $xml = $api->getXmlSigned($despatch);
        $hash = (new XmlUtils())->getHashSign($xml);
        $despatche->xml_hash = $hash;
        $despatche->xml_path = 'xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml';
        $despatche->save();
        Storage::disk('public')->put('xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml', $xml);
        //return $xml;
    }
    public function xmlDownload(Despatche $despatche)
    {
        if (Storage::exists($despatche->xml_path)) {
            return Storage::disk('public')->download($despatche->xml_path);
        }
    }
    public function sendXmlFile(Despatche $despatche)
    {
        $company = $despatche->company;
        $sunat = new SunatServiceGre();

        
        $despatch = $sunat->getDespatch($despatche);
        $api = $sunat->getSeeApi($company);
        dd($api);
        $result = $api->send($despatch);

       dd($result->isSuccess());
        $response['sunatResponse'] = $sunat->sunatResponse($result);
        $response['xml'] = $api->getLastXml();
        $response['hash'] = (new XmlUtils())->getHashSign($response['xml']);
        return response()->json($response, 200);
    }
    public function downloadCdrFile(Despatche $despatche)
    {
        if (Storage::exists($despatche->cdr_path)) {
            return Storage::disk('public')->download($despatche->cdr_path);
        }
    }
}
