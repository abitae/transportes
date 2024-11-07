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
        $caja = Caja::where('user_id', $user->id)
            ->where('isActive', true)
            ->latest()->first();
        return $caja;
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
    function cajaEntry(int $caja_id, float $monto, string $description, string $tipo)
    {
        try {
            $entryCaja = EntryCaja::create([
                'caja_id' => $caja_id,
                'monto_entry' => $monto,
                'description' => $description,
                'tipo' => $tipo,
            ]);
            return $entryCaja;
        } catch (\Exception $e) {
            $this->errorLog('CajaTrait cajaEntry', $e);
            return null;
        }
    }
    /*
     *   Función para agregar exit
     */
    function cajaExit(int $caja_id, float $monto, string $description, string $tipo)
    {
        try {
            $exitCaja = ExitCaja::create([
                'caja_id' => $caja_id,
                'monto_entry' => $monto,
                'description' => $description,
                'tipo' => $tipo,
            ]);
            return $exitCaja;
        } catch (\Exception $e) {
            $this->errorLog('CajaTrait cajaExit', $e);
            return null;
        }
    }
    /*
     *   Función para imprimir reporte de caja
     */
    public function cajaPrint(Caja $caja)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, ($width / 25.4) * 72, ($heigh / 25.4) * 72);

        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('report.pdf.caja', compact('caja'));
        //return $pdf->stream();
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $caja->id . '.pdf');
    }
}
