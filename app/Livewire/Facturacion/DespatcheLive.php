<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Despatche;
use App\Services\SunatServiceGlobal;
use App\Services\SunatServiceGre;
use App\Traits\LogCustom;
use Greenter\Model\DocumentInterface;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DespatcheLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'GUIA DE REMICION TRANSPORTISTA';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage = 10;
    public string $cdr_code;
    public string $cdr_description;
    public string $cdr_note;
    public string $errorCode;
    public string $errorMessage;
    public string $ticket;
    public bool $infoModal = false;
    public Despatche $despatche;
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
        //dd($guiaT);
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
        $guiaT = $sunat->getDespatch($despatche);
        $api = $sunat->getSeeApi($company);
        $result = $api->send($guiaT);
        $ticket = $result->getTicket();
        $result = $api->getStatus($ticket);
        $response = $sunat->sunatResponse($result);
        $this->infoLog('prueba ' . $response);
        if ($response['success']) {
            $despatche->cdr_description = $response['cdrResponse']['description'];
            $despatche->cdr_code = $response['cdrResponse']['code'];
            $despatche->cdr_note = $response['cdrResponse']['notes'];
            $despatche->cdr_path = 'cdr/' . 'R-' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.zip';
            $despatche->ticket = $ticket;
            $despatche->save();
            $cdr = $result->getCdrZip();
            Storage::disk('public')->put($despatche->cdr_path, $cdr);
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
    public function statusDespatch(Despatche $despatche)
    {
        $this->despatche = $despatche;
        $this->cdr_code = $despatche->cdr_code ?? 'No hay código';
        $this->cdr_description = $despatche->cdr_description ?? 'No hay descripción';
        $this->cdr_note = $despatche->cdr_note ?? 'No hay nota';
        $this->errorCode = $despatche->errorCode ?? 'No hay error';
        $this->errorMessage = $despatche->errorMessage ?? 'No hay error';
        $this->ticket = $despatche->ticket ?? 'No hay ticket';
        $this->infoModal = true;
    }
    public function ActualizarDespatche(Despatche $despatche)
    {
        $company = $despatche->company;
        $sunat = new SunatServiceGlobal();
        $api = $sunat->getSeeApi($company);
        $result = $api->getStatus($despatche->ticket);
        $response = $sunat->sunatResponse($result);
        if ($response['success']) {
            $despatche->cdr_description = $response['cdrResponse']['description'];
            $despatche->cdr_code = $response['cdrResponse']['code'];
            $despatche->cdr_note = $response['cdrResponse']['notes'];
            $despatche->cdr_path = 'cdr/' . 'R-' . $despatche->company->ruc . '-' . $despatche->tipoDoc . '-' . $despatche->serie . '-' . $despatche->correlativo . '.zip';
            $despatche->ticket = $despatche->ticket;
            $despatche->save();
            $cdr = $result->getCdrZip();
            Storage::disk('public')->put($despatche->cdr_path, $cdr);
            $this->toast('success', 'Comprobante enviado a la sunat');
        } else {
            $despatche->errorCode = $response['error']['code'];
            $despatche->errorMessage = $response['error']['message'];
            $despatche->save();
            $this->toast('error', 'Error al enviar el comprobante a la sunat');
        }
        $this->infoModal = false;
    }
    public function save()
    {
        $rules = [
            'ticket' => 'required|string|max:255',
        ];
        $messages = [
            'ticket.required' => 'El ticket es requerido',
            'ticket.string' => 'El ticket debe ser una cadena de caracteres',
            'ticket.max' => 'El ticket debe tener máximo 255 caracteres',
        ];
        $this->validate($rules, $messages);
        $this->despatche->ticket = $this->ticket;
        $this->despatche->save();
        $this->toast('success', 'Ticket actualizado');
        $this->infoModal = false;
    }
}
