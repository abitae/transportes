<?php
namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Note;
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
}
