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
        $heigh = 200 + $ticket->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.ticket.80mm',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, $heigh],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 1,
                'margin_right' => 10,
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
                'watermark' => $ticket->encomienda->estado_pago,
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
    public function invoice80mm(Invoice $invoice)
    {

        $data = [
            'invoice' => $invoice,
        ];
        $heigh = 200 + $invoice->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.invoice.80mm',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, $heigh],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 1,
                'margin_right' => 10,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $invoice->serie . '-' . $invoice->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $invoice->encomienda->estado_pago,
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
    public function despache80mm(Despatche $despache)
    {
        $data = [
            'despache' => $despache,
        ];
        $heigh = 350 + $despache->details->count() * 8;
        $pdf = Pdf::loadView(
            'pdfs.despache.80mm',
            $data,
            [],
            [
                'mode' => '',
                'format' => [80, $heigh],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 1,
                'margin_right' => 10,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $despache->serie . '-' . $despache->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => $despache->encomienda->estado_pago,
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
        return $pdf->stream($despache->serie . '.pdf');
    }
    public function stickerA5(Encomienda $encomienda)
    {
        $data = [
            'encomienda' => $encomienda,
        ];

        $pdf = Pdf::loadView(
            'pdfs.sticker.a6',
            $data,
            [],
            [
                'mode' => '',
                'format' => [148, 105],
                'default_font_size' => '12',
                'default_font' => 'sans-serif',
                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'P',
                'title' => $encomienda->code,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                'watermark' => $encomienda->estado_pago,
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
        return $pdf->stream($encomienda->serie . '.pdf');
    }

    public function ticketA4(Ticket $ticket)
    {
        $data = [
            'ticket' => $ticket,
        ];
        $pdf = Pdf::loadView('pdfs.ticket.ticket-a4', $data);
        return $pdf->stream($ticket->serie . '.pdf');
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
                'title' => $invoice->serie . '-' . $invoice->correlativo,
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => 'Abel Arana',
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
    public function declaracion(Encomienda $encomienda)
    {
        $data = [
            'encomienda' => $encomienda,
        ];
        $pdf = Pdf::loadView(
            'pdfs.documentacion.declaracion',
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
                'title' => 'Declaración de Envío',
                'author' => 'Abel Arana',
                'creator' => 'Abel Arana',
                'subject' => 'Abel Arana',
                'keywords' => 'Abel Arana',
                //'watermark' => 'Abel Arana',
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
        return $pdf->stream($encomienda->code . '.pdf');
    }
}
