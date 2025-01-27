<?php

namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class RecordPackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Encomiendas entregadas';
    public $sub_title = 'Modulo de paquetes entregados';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id;
    public $date_ini;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id;
    public $vehiculo_id;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $caja;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->sucursal_dest_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('isActive', $this->isActive)
            ->where('sucursal_id', $this->sucursal_dest_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'ENTREGADO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%'))
            ->latest()
            ->paginate($this->perPage, '*', 'page');

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();

        return view('livewire.package.record-package-live', compact('encomiendas', 'sucursals', 'transportistas', 'vehiculos'));
    }

    
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    
    public function printTicket(Encomienda $envio)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, 220, 710);
        
        $pdf = Pdf::setPaper($paper_format, 'portrait')->loadView('report.pdf.ticket', compact('envio'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'T'.$envio->code . '.pdf');
    }
    public function printSticker(Encomienda $envio)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, 220, 710);
        
        $pdf = Pdf::loadView('report.pdf.sticker', compact('envio'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'S'.$envio->code . '.pdf');
    }
}
