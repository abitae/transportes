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
        $sunat = new SunatServiceGre();
        $api = $sunat->getSee($company);
        $despatch = $sunat->getDespatch($despatche);
        $xml = $api->getXmlSigned($despatch);
        $hash = (new XmlUtils())->getHashSign($xml);
        $despatche->update([
            'xml_hash' => $hash,
            'xml_path' => 'xml/' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.xml'
        ]);
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
        $sunat = new SunatServiceGre();
        $despatch = $sunat->getDespatch($despatche);
        $api = $sunat->getSeeApi($company);
        $result = $api->send($despatch);

        if ($result->isSuccess()) {
            $ticket = $result->getTicket();
            $statusResult = $api->getStatus($ticket);
            $response = $sunat->sunatResponse($statusResult);

            if ($response['success']) {
                $despatche->update([
                    'cdr_path' => 'cdr/' . 'R-' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.zip'
                ]);
                Storage::disk('public')->put($despatche->cdr_path, $response['cdrResponse']['cdrZip']);
                $this->toast('success', 'Guia enviada a la sunat');
            } else {
                $this->toast('error', 'Error al enviar la guia a la sunat');
            }
        } else {
            $this->toast('error', 'Error al enviar la guia a la sunat');
        }
    }

    public function downloadCdrFile(Despatche $despatche)
    {
        if (Storage::exists($despatche->cdr_path)) {
            return response()->download(storage_path('app/public/' . $despatche->cdr_path));
        }
    }
}
