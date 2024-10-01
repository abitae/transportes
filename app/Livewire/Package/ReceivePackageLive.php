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

class ReceivePackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Recibir paquetes';
    public $sub_title = 'Modulo de recepcion de paquetes';
    public $perPage = 100;
    public array $selected = [];
    public $search;
    public $date_ini;
    public $date_traslado;
    public int $sucursal_id;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalEnvio = false;
    public function mount()
    {

        $this->sucursal_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)->where('sucursal_id', $this->sucursal_id)->where(
            fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
        )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.receive-package-live', compact('encomiendas', 'sucursals'));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_rem = Sucursal::findOrFail($this->sucursal_id);
            $this->modalEnvio = !$this->modalEnvio;
        }
    }
    public function deliverPaquetes()
    {
        dump($this->selected);
    }

}
