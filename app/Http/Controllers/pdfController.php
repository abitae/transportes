<?php

namespace App\Http\Controllers;

use App\Models\Facturacion\Ticket;

use Spatie\LaravelPdf\Enums\Format;

use Barryvdh\DomPDF\Facade\Pdf;
use function Spatie\LaravelPdf\Support\pdf;

class pdfController extends Controller
{
    public function print80mm(Ticket $ticket){

        return pdf()
        ->view('pdfs.ticket.80mm', compact('ticket'))
        ->paperSize(80, 500, 'mm')
        ->name('invoice-2023-04-10.pdf');
    }
    public function printA4(Ticket $ticket)
    {
        return pdf()
        ->view('pdfs.ticket.a4', compact('ticket'))
        ->format(Format::A4)
        ->name('invoice-2023-04-10.pdf');
    }
}
