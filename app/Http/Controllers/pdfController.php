<?php

namespace App\Http\Controllers;

use App\Models\Facturacion\Despatche;
use App\Models\Facturacion\Invoice;
use App\Models\Facturacion\Ticket;
use App\Models\Package\Encomienda;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;

class pdfController extends Controller
{
    public function ticket80mm(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $heigh = 236 + $ticket->details->count() * 10;
        $pdf = Pdf::loadView(
            'pdfs.ticket.80mm',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, $heigh],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $ticket->serie,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => 'Abel Arana',
                'show_watermark' => true,
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
        return $pdf->stream($ticket->serie . '.pdf');
    }
    public function ticketA4(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $pdf = Pdf::loadView('pdfs.ticket.ticket-a4', $data);
        return $pdf->stream($ticket->serie . '.pdf');
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
        $data = [
            'invoice' => $invoice,
        ];
        $pdf = Pdf::loadView(
            'pdfs.invoice.a4',
            $data,
            [],
            [
                'mode' => '',
                'format' => 'A4',
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 10,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $invoice->serie. ' ' . $invoice->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => 'Abel Arana',
                'show_watermark' => true,
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
        return $pdf->stream($invoice->serie . '.pdf');
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
        $pdf = DomPdf::setPaper($paper_format, 'portrait')
            ->setOption(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('pdfs.despache.80mm', $data);
        return $pdf->stream('guia.pdf');
    }
    public function despacheA4(Despatche $despache) {}
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
    public function noteA4(Invoice $invoice) {}
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
