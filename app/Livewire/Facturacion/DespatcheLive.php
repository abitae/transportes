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
    public string $title     = 'Guia de Transportista';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage      = 10;
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
        $despatch            = $sunat->getDespatch($despatche);
        $xml                 = $api->getXmlSigned($despatch);
        $hash                = (new XmlUtils())->getHashSign($xml);
        $despatche->xml_hash = $hash;
        $despatche->xml_path = 'xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml';
        $despatche->save();
        Storage::disk('public')->put('xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml', $xml);
        //return $xml;
    }
    public function xmlDownload(Despatche $despatche)
    {
        if (Storage::exists($despatche->xml_path)) {
            return response()->download(storage_path('app/public/' . $despatche->xml_path));

        }
    }
    public function sendXmlFile(Despatche $despatche)
    {
        //dd($despatche);
        $company = $despatche->company;
        //dd($company);
        $sunat = new SunatServiceGre();
        //creo la configuracion see
        $despatch = $sunat->getDespatch($despatche);
        //dd($despatch);
        $api = $sunat->getSeeApi($company);
        //dd($api);
        $result = $api->send($despatch);
        dd($result->isSuccess(), $result->getError());
        $ticket = $result->getTicket();
        $result = $api->getStatus($ticket);
        $response['sunatResponse'] = $sunat->sunatResponse($result);

        dump($response['sunatResponse']);

    }
    public function downloadCdrFile(Despatche $despatche)
    {
        if (Storage::exists($despatche->cdr_path)) {
            return response()->download(storage_path('app/public/' . $despatche->cdr_path));
        }
    }
}
