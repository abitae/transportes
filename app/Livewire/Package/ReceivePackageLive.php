<?php

namespace App\Livewire\Package;

use App\Models\Caja\Caja;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ReceivePackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;

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
            return $this->redirectRoute('caja.index');
        }
        $this->sucursal_id = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->first()->id;
        $this->date_ini = now()->setTimezone('America/Lima')->format('Y-m-d');
    }

    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)
            ->whereNotIn('id', [Auth::user()->sucursal->id])
            ->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'ENVIADO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%'))
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.receive-package-live', compact('encomiendas', 'sucursals'));
    }

    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_rem = Sucursal::findOrFail($this->sucursal_id);
            $this->toggleModalEnvio();
        } else {
            $this->error('Seleccione al menos un paquete!');
        }
    }

    public function receivePaquetes()
    {
        $retorno = Encomienda::whereIn('id', $this->selected)->update([
            'estado_encomienda' => 'RECIBIDO',
            'updated_at' => now()->setTimezone('America/Lima')->format('Y-m-d H:i:s'),
        ]);
        if (count($this->selected) == $retorno) {
            $this->success('Genial, ingresado correctamente!');
            $this->resetSelection();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    private function toggleModalEnvio()
    {
        $this->modalEnvio = !$this->modalEnvio;
    }

    private function resetSelection()
    {
        $this->modalEnvio = false;
        $this->selected = [];
    }
}