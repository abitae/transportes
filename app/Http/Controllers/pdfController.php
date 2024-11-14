<?php

namespace App\Http\Controllers;

use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;

use Spatie\LaravelPdf\Enums\Format;

use Barryvdh\DomPDF\Facade\Pdf;
use function Spatie\LaravelPdf\Support\pdf;

class pdfController extends Controller
{
    public function ticket80mm(Ticket $ticket){

        return pdf()
        ->view('pdfs.ticket.80mm', compact('ticket'))
        ->paperSize(80, 500, 'mm')
        ->name('invoice-2023-04-10.pdf');
    }
    public function ticketA4(Ticket $ticket)
    {
        return pdf()
        ->view('pdfs.ticket.a4', compact('ticket'))
        ->format(Format::A4)
        ->name('invoice-2023-04-10.pdf');
    }
    public function invoice80mm(Invoice $invoice){

        return pdf()
        ->view('pdfs.invoice.80mm', compact('invoice'))
        ->paperSize(80, 500, 'mm')
        ->name('invoice-2023-04-10.pdf');
    }
    public function invoiceA4(Invoice $invoice)
    {
        return pdf()
        ->view('pdfs.invoice.a4', compact('invoice'))
        ->format(Format::A4)
        ->name('invoice-2023-04-10.pdf');
    }
    //-------------------------------------------------------
    public function guia80mm(Invoice $invoice)
    {
        return pdf()
        ->view('pdfs.invoice.a4', compact('invoice'))
        ->format(Format::A4)
        ->name('invoice-2023-04-10.pdf');
    }
    public function sticketA5(Invoice $invoice)
    {
        return pdf()
        ->view('pdfs.invoice.a4', compact('invoice'))
        ->format(Format::A4)
        ->name('invoice-2023-04-10.pdf');
    }
}
