<?php
namespace App\Http\Controllers;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
use App\Models\Package\Encomienda;
//use Barryvdh\DomPDF\Facade\Pdf;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;

class pdfController extends Controller
{
    public function ticket80mm(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $pdf = Pdf::loadView(
            'pdfs.ticket.ticket-a4',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, 236],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => 'Laravel mPDF',
                'author' => '',
                'creator' => '',
                'subject' => '',
                'keywords' => '',
                'watermark' => '',
                'show_watermark' => false,
                'show_watermark_image' => false,
                'watermark_font' => 'sans-serif',
                'display_mode' => 'fullpage',
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
                'custom_font_dir' => '',
                'custom_font_data' => [],
                'auto_language_detection' => false,
                'temp_dir' => storage_path('app'),
                'pdfa' => false,
                'pdfaauto' => false,
                'use_active_forms' => false,
            ]
        );
        return $pdf->stream('invoice.pdf');
    }
    public function ticket80mm1(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $heigh = 600 + $ticket->details->count() * 30;
        $paper_format = [0, 0, 250, $heigh];

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.ticket.80mm', $data);
        return $pdf->stream('invoice.pdf');
    }
    public function invoice80mm(Invoice $invoice)
    {

        $data = [
            'invoice' => $invoice,
        ];
        $heigh = 600 + $invoice->details->count() * 30;
        $paper_format = [0, 0, 250, $heigh];

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.invoice.80mm', $data);
        return $pdf->stream('invoice.pdf');
    }
    public function invoiceA4(Invoice $invoice)
    {

    }
    //-------------------------------------------------------
    public function despache80mm(Despatche $despache)
    {
        $data = [
            'despache' => $despache,
        ];
        $heigh = 1700 + $despache->details->count() * 30;
        $paper_format = [0, 0, 250, $heigh];
        $data = [
            'despache' => $despache,
            'heigh' => $heigh,
        ];
        $pdf = Pdf::setPaper($paper_format, 'portrait')
            ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('pdfs.despache.80mm', $data);
        return $pdf->stream('guia.pdf');
    }
    public function despacheA4(Despatche $despache)
    {

    }
    public function note80mm(Invoice $invoice)
    {

        $data = [
            'invoice' => $invoice,
        ];
        $heigh = 600 + $invoice->details->count() * 30;
        $paper_format = [0, 0, 250, $heigh];

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('pdfs.invoice.80mm', $data);
        return $pdf->stream('invoice.pdf');
    }
    public function noteA4(Invoice $invoice)
    {

    }
    public function stickerA5(Encomienda $encomienda)
    {
        $data = [
            'encomienda' => $encomienda,
        ];
        //$heigh = 1400 + $encomienda->details->count() * 30;
        $paper_format = [0, 0, 297.64, 419.53];

        $pdf = Pdf::setPaper($paper_format, 'landscape')->loadView('pdfs.sticker.a6', $data);
        return $pdf->stream('sticker.pdf');
    }
}
