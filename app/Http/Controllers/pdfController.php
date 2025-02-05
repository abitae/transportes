<?php

namespace App\Http\Controllers;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
use App\Models\Package\Encomienda;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\LaravelPdf\Enums\Format;

use function Spatie\LaravelPdf\Support\pdf;

class pdfController extends Controller
{
    public function ticket80mm(Ticket $ticket){
        $data = [
            'ticket' => $ticket
        ];
        $heigh = 600 + $ticket->details->count() * 30;
        $paper_format = array(0, 0, 250, $heigh);
        
        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.ticket.80mm', $data);
        return $pdf->stream('invoice.pdf');
    }
    
    public function invoice80mm(Invoice $invoice){

        $data = [
            'invoice' => $invoice
        ];
        $heigh = 600 + $invoice->details->count() * 30;
        $paper_format = array(0, 0, 250, $heigh);
        
        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.invoice.80mm', $data);
        return $pdf->stream('invoice.pdf');
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
        $data = [
            'despache' => $despache
        ];
        $heigh = 1400 + $despache->details->count() * 30;
        $paper_format = array(0, 0, 250, $heigh);
        
        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.despache.80mm', $data);
        return $pdf->stream('guia.pdf');
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
        $data = [
            'encomienda' => $encomienda
        ];
        //$heigh = 1400 + $encomienda->details->count() * 30;
        $paper_format = array(0,0,297.64,419.53);
        
        $pdf = Pdf::setPaper($paper_format, 'landscape')->loadView('pdfs.sticker.a6', $data);
        return $pdf->stream('sticker.pdf');
    }
}
