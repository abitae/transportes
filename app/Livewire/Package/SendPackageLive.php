<?php

namespace App\Livewire\Package;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Encomienda;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Enviar paquetes';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id;
    public $date_ini;
    public $date_traslado;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id;
    public $vehiculo_id;
    public function mount()
    {
        $this->sucursal_dest_id = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->first()->id;
        $this->date_ini = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->id])->get();
        
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_dest_id', $this->sucursal_dest_id)
            ->where('estado_encomienda', 'REGISTRADO')
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            )->paginate($this->perPage, '*', 'page');

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        return view('livewire.package.send-package-live', compact('encomiendas', 'sucursals', 'transportistas', 'vehiculos'));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_dest = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->modalEnvio = !$this->modalEnvio;
        }
    }
    public function sendPaquetes()
    {
        $retorno = Encomienda::whereIn('id', $this->selected)->update([
            'estado_encomienda' => 'ENVIADO',
            'updated_at' => $this->date_traslado,
            'vehiculo_id' => $this->vehiculo_id,
            'transportista_id' => $this->transportista_id,
        ]);
        if (count($this->selected) == $retorno) {
            $this->success('Genial, ingresado correctamente!');
            $this->modalEnvio = false;
            $this->selected = [];
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
