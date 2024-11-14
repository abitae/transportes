<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Invoice;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class InvoiceLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'Facturacion';
    public string $sub_title = 'Modulo de facturacion';
    public int $perPage = 10;
    public function render()
    {
        $invoices = Invoice::latest()->paginate($this->perPage);
        return view('livewire.facturacion.invoice-live', compact('invoices'));
    }
}
