<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Ticket;
use function Spatie\LaravelPdf\Support\pdf;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\LaravelPdf\Facades\Pdf;

class TicketLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public string $title = 'Ticket';
    public string $sub_title = 'Modulo de ticket';
    public int $perPage = 10;
    public function render()
    {
        $tickets = Ticket::latest()->paginate($this->perPage);
        return view('livewire.facturacion.ticket-live', compact('tickets'));
    }
}
