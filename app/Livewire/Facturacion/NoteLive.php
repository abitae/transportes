<?php
namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Note;
use App\Services\SunatServiceGlobal;
use Greenter\Report\XmlUtils;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class NoteLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'NOTAS DE CREDITO';
    public string $sub_title = 'Modulo de notas de credito';
    public int $perPage = 10;
    public $infoModal = false;

    public $cdr_code;
    public $cdr_description;
    public $cdr_note;
    public $errorCode;
    public $errorMessage;
    public function render()
    {
        $notes = Note::latest()->paginate($this->perPage);
        return view('livewire.facturacion.note-live',compact('notes'));
    }
    public function xmlGenerate(Note $note)
    {
        $company = $note->company;
        $sunat = new SunatServiceGlobal();
        $see = $sunat->getSee($company);
        $invoce = $sunat->getNote($note);
        $xml = $see->getXmlSigned($invoce);
        $hash = (new XmlUtils())->getHashSign($xml);
        $note->xml_hash = $hash;
        $note->xml_path = 'xml/' . $note->company->ruc . '-' . $note->tipoDoc . '-' . $note->serie . '-' . $note->correlativo . '.xml';
        $note->save();
        Storage::disk('public')->put($note->xml_path, $xml);
    }
    public function xmlDownload(Note $note)
    {
        if (Storage::exists($note->xml_path)) {
            return response()->download(storage_path('app/public/' . $note->xml_path));
        }
    }
}
