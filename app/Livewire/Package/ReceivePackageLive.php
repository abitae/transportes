<?php

namespace App\Livewire\Package;

use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReceivePackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Recibir paquetes';
    public $sub_title = 'Modulo de recepcion de paquetes';
    public $perPage = 100;
    public array $selected = [];
    public $search;
    public $date_ini;
    public int $sucursal_id;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalEnvio = false;
    public $caja;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if (!$this->caja) {
            $this->redirectRoute('caja.index');
        }
        $this->sucursal_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');

    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'ENVIADO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.receive-package-live', compact('encomiendas', 'sucursals'));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_rem = Sucursal::findOrFail($this->sucursal_id);
            $this->modalEnvio = !$this->modalEnvio;
        }
    }
    public function receivePaquetes()
    {
        $retorno = Encomienda::whereIn('id', $this->selected)->update([
            'estado_encomienda' => 'RECIBIDO',
            'updated_at' => \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d H:i:s'),
        ]);
        if (count($this->selected) == $retorno) {
            $this->success('Genial, ingresado correctamente!');
            $this->modalEnvio = false;
            $this->selected = [];
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
    public function printEncomienda(Encomienda $envio)
    {
        $width = 78;
        $heigh = 250;
        $paper_format = array(0, 0, 220, 710);
        
        $pdf = Pdf::setPaper($paper_format,'portrait')->loadView('report.pdf.ticket', compact('envio'));
        //return $pdf->stream();
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $envio->code . '.pdf');
    }
}
