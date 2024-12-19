<?php

namespace App\Http\Controllers;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
use App\Models\Package\Encomienda;
use Spatie\LaravelPdf\Enums\Format;

use function Spatie\LaravelPdf\Support\pdf;

class pdfController extends Controller
{
    public function ticket80mm(Ticket $ticket){

        return pdf()
        ->view('pdfs.ticket.80mm', compact('ticket'))
        ->paperSize(80, 500, 'mm')
        ->name('invoice.pdf');
    }
    
    public function invoice80mm(Invoice $invoice){

        return pdf()
        ->view('pdfs.invoice.80mm', compact('invoice'))
        ->paperSize(80, 500, 'mm')
        ->name('invoice.pdf');
    }
    public function invoiceA4(Invoice $invoice)
    {
        return pdf()
        ->view('pdfs.invoice.a4', compact('invoice'))
        ->format(Format::A4)
        ->name('invoice.pdf');
    }
    //-------------------------------------------------------
    public function despache80mm(Despatche $despache)
    {
        return pdf()
        ->view('pdfs.despache.80mm', compact('despache'))
        ->paperSize(80, 500, 'mm')
        ->name('despache.pdf');
    }
    public function despacheA4(Despatche $despache)
    {
        return pdf()
        ->view('pdfs.despache.a4', compact('despache'))
        //->format(Format::A4)
        ->name('despache.pdf');
    }
    public function stickerA5(Encomienda $encomienda)
    {
        return pdf()
        ->view('pdfs.sticker.a5', compact('encomienda'))
        ->format(Format::A5)
        ->name('despache.pdf');
    }
}
