<?php

namespace App\Livewire\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Enviar paquetes';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 10;
    public array $selected = [];
    public int $sucursal_dest_id;
    public $myDate3;
    public function mount()
    {
        $this->sucursal_dest_id = Sucursal::first()->id;
        $this->myDate3 = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        
        $sucursals = Sucursal::where('isActive', true)->get();
        $encomiendas = Encomienda::where('sucursal_dest_id', $this->sucursal_dest_id)->where(
            fn($query)
            => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
        )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.send-package-live', compact('encomiendas', 'sucursals'));
    }
    public function openModal()
    {
        dump($this->myDate3);
    }
}
