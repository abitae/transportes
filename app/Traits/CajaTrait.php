<?php
namespace App\Traits;

use App\Models\Caja\Caja;
use App\Models\Caja\EntryCaja;
use App\Models\Caja\ExitCaja;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

trait CajaTrait
{
    /*
     *   Función para obtener la caja abierta
     */
    function cajaIsActive(User $user)
    {
        return Caja::where('user_id', $user->id)
            ->where('isActive', true)
            ->latest()->first();
    }
    /*
     *   Función para obtener la caja cerrada
     */
    function cajaListPaginate(User $user, $paginate)
    {
        return Caja::where('user_id', $user->id)
            ->latest()->paginate($paginate);
    }
    /*
     *   Función para agregar entrada
     */
    function cajaEntry(int $caja_id, float $monto, string $description,string $metodo_pago, string $tipo)
    {
        $entry = EntryCaja::create([
            'caja_id' => $caja_id,
            'monto_entry' => $monto,
            'description' => $description,
            'metodo_pago' => $metodo_pago,
            'tipo_entry' => $tipo,
        ]);
        return $entry;
    }

    /*
     *   Función para agregar exit
     */
    function cajaExit(int $caja_id, float $monto, string $description,string $metodo_pago, string $tipo)
    {
        $exit = ExitCaja::create([
            'caja_id' => $caja_id,
            'monto_exit' => $monto,
            'description' => $description,
            'metodo_pago' => $metodo_pago,
            'tipo_exit' => $tipo,
        ]);
        return $exit;
    }
    /*
     *   Función para crear entrada o salida de caja
     */

    /*
     *   Función para imprimir reporte de caja
     */
    public function cajaPrint(Caja $caja)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, ($width / 25.4) * 72, ($heigh / 25.4) * 72);

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('report.pdf.caja', compact('caja'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $caja->id . '.pdf');
    }
}
