<?php

namespace App\Livewire\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DeliverPackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Entrega paquetes';
    public $sub_title = 'Modulo de entrega de paquetes';
    public $search = '';
    public $perPage = 10;
    public $date_ini;
    public int $sucursal_id;
    public $date_traslado;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalDeliver = false;
    public $encomienda;
    public $document;
    public $pin;
    public function mount()
    {
        $this->sucursal_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereIn('id', [Auth::user()->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.deliver-package-live', compact('encomiendas', 'sucursals'));
    }
    public function openModal($id)
    {
        $this->modalDeliver = !$this->modalDeliver;
        $this->encomienda = Encomienda::find($id);
    }
    public function deliverPaquetes()
    {
        if ($this->encomienda->destinatario->code == $this->document and $this->encomienda->pin == $this->pin) {
            $this->success('Genial, ingresado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }

    }
}
