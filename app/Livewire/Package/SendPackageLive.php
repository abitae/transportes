<?php

namespace App\Livewire\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Customer;
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
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public array $selected = [];
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->get();
        $customers = Customer::where(
            fn($query)
            => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        )->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.send-package-live', compact('customers', 'sucursals'));
    }
    public function openModal()
    {
        dump($this->selected);
    }
}
