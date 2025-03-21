<?php

namespace App\Livewire\Report;

use App\Exports\ReportEncomiendaExport;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class EncomiendasReport extends Component
{
    use Toast, UtilsTrait;
    use WithPagination, WithoutUrlPagination;
    public $title = 'REPORTE ENCOMIENDAS';
    public $sub_title = 'Modulo de reporte de encomiendas detallado';
    public $filtroSucursal;
    public $filtroFechaInicio;
    public $filtroFechaFin;
    public $search;
    public $FiltroEstadoEncomienda;
    public $FiltroEstadoPago;
    public $filtroMetodoPago;
    public int $perPage = 10;
    public bool $showDrawer = false;
    public $ids;
    public Encomienda $encomienda;
    public function mount()
    {
        $this->filtroFechaInicio = Carbon::now()->startOfDay()->format('Y-m-d H:i');//$this->dateNow('Y-m-d');
        $this->filtroFechaFin = $this->dateNow('Y-m-d H:i:s');
    }
    public function render()
    {
        $encomiendas = Encomienda::query();

        if ($this->filtroSucursal) {
            $encomiendas->where('sucursal_id', $this->filtroSucursal);
        }

        if ($this->filtroFechaInicio && $this->filtroFechaFin) {
            $encomiendas->whereBetween('created_at', [$this->filtroFechaInicio, $this->filtroFechaFin]);
        }

        if ($this->search) {
            $encomiendas->where(function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('remitente', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('destinatario', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('code', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->FiltroEstadoEncomienda) {
            $encomiendas->where('estado_encomienda', $this->FiltroEstadoEncomienda);
        }

        if ($this->FiltroEstadoPago) {
            $encomiendas->where('tipo_pago', $this->FiltroEstadoPago);
        }

        if ($this->filtroMetodoPago) {
            $encomiendas->where('metodo_pago', $this->filtroMetodoPago);
        }
        $this->ids = $encomiendas->pluck('id')->toArray();
        $encomiendas = $encomiendas->latest()->paginate($this->perPage);
        $sucursals = Sucursal::where('isActive', true)->get();
        $estados = [
            ['id' => 'REGISTRADO', 'name' => 'REGISTRADO'],
            ['id' => 'ENVIADO', 'name' => 'ENVIADO'],
            ['id' => 'RECIBIDO', 'name' => 'RECIBIDO'],
            ['id' => 'ENTREGADO', 'name' => 'ENTREGADO']
        ];
        $estadosPago = [
            ['id' => 'Contado', 'name' => 'Contado'],
            ['id' => 'Credito', 'name' => 'Credito'],
        ];
        return view('livewire.report.encomiendas-report', [
            'encomiendas' => $encomiendas,
            'sucursals' => $sucursals,
            'estados' => $estados,
            'estadosPago' => $estadosPago,
        ]);
    }
    public function showEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
    public function createBoleta(Encomienda $encomienda)
    {
        $this->redirectRoute(
            'facturacion.create-invoice',
            ['id' => $encomienda->id],
            false, false
        );
    }
    public function excelGenerate()
    {   
        return Excel::download(new ReportEncomiendaExport($this->ids), 'report_encomienda.xlsx');
    }
}
