<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Despatche;
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
        return view('livewire.facturacion.despatche-live',compact('despaches'));
    }
}
