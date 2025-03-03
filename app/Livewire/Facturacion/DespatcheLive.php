<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Despatche;
use App\Services\SunatServiceGlobal;
use App\Services\SunatServiceGre;
use Greenter\Model\DocumentInterface;
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
    public string $title = 'GUIA DE REMICION TRANSPORTISTA';
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
        $sunat = new SunatServiceGlobal();
        $api = $sunat->getSee($company);
        $guiaT = $sunat->getDespatch($despatche);
        $xml = $api->getXmlSigned($guiaT);
        $hash = (new XmlUtils())->getHashSign($xml);
        $despatche->xml_hash = $hash;
        $despatche->xml_path = 'xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml';
        $despatche->save();
        Storage::disk('public')->put($despatche->xml_path, $xml);
    }

    public function xmlDownload(Despatche $despatche)
    {
        if (Storage::exists($despatche->xml_path)) {
            return response()->download(storage_path('app/public/' . $despatche->xml_path));
        }
    }

    public function sendXmlFile(Despatche $despatche)
    {
        $company = $despatche->company;
        $sunat = new SunatServiceGlobal();
        $guiaT = $sunat->getDespatch();
        $api = $sunat->getSeeApi($company);
        $result = $api->send($guiaT);   
        $ticket = $result->getTicket();
        $result = $api->getStatus($ticket);
        $response = $sunat->sunatResponse($result);

        if ($response['success']) {
            $despatche->cdr_description = $response['cdrResponse']['description'];
            $despatche->cdr_code = $response['cdrResponse']['code'];
            $despatche->cdr_note = $response['cdrResponse']['notes'];
            $despatche->cdr_path = 'cdr/' . 'R-' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.zip';
            $despatche->save();
            $cdr = $result->getCdrZip();
            Storage::disk('public')->put($despatche->cdr_path, $cdr );
            $this->toast('success', 'Comprobante enviado a la sunat');
        } else {
            $despatche->errorCode = $response['error']['code'];
            $despatche->errorMessage = $response['error']['message'];
            $despatche->save();
            $this->toast('error', 'Error al enviar el comprobante a la sunat');
        }
    }
    public function downloadCdrFile(Despatche $despatche)
    {
        if (Storage::exists($despatche->cdr_path)) {
            return response()->download(storage_path('app/public/' . $despatche->cdr_path));
        }
    }
}
