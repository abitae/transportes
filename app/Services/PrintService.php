<?php

namespace App\Services;

use App\Models\Package\Encomienda;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintService
{
    public function printTicket(Encomienda $envio)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, 220, 710);

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('report.pdf.ticket', compact('envio'));
        //return $pdf->stream();
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $envio->code . '.pdf');
    }
}
