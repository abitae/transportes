<?php

namespace App\Livewire\Facturacion;

use App\Models\Facturacion\Ticket;
use function Spatie\LaravelPdf\Support\pdf;
use Livewire\Component;
use Mary\Traits\Toast;
use Spatie\LaravelPdf\Facades\Pdf;

class TicketLive extends Component
{
    use Toast;
    public string $title = 'Ticket';
    public string $sub_title = 'Modulo de ticket';
    public int $perPage = 10;
    public function render()
    {
        $tickets = Ticket::latest()->paginate($this->perPage);
        return view('livewire.facturacion.ticket-live', compact('tickets'));
    }
    public function printA4(Ticket $ticket)
    {
       Pdf::view('pdfs.ticket', ['ticket' => $ticket])
            ->save('storage/ticket/' . $ticket->id.'.pdf');
    }
    public function printTicket(Ticket $ticket)
    {
        dump($ticket);
        return pdf()
        ->view('pdfs.ticket.80mm', compact('ticket'))
        ->name('invoice-2023-04-10.pdf')
        ->download();
    }

}
