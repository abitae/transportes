<?php

namespace App\Livewire\Configuration;

use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SucursalConfigurationLive extends Component
{
    public $sucursal_destino_id, $vehiculo_id, $transportista_id, $date_config;
    public function render()
    {
        $configurations = SucursalConfiguration::where('sucursal_id', Auth::user()->sucursal->id)->where('isActive', true)->get();
        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        $sucursales = Sucursal::where('isActive', true)->whereNotIn('id', [Auth::user()->sucursal->id])->get();
        return view('livewire.configuration.sucursal-configuration-live', compact('configurations', 'transportistas', 'vehiculos', 'sucursales'));
    }
    public function save()
    {
        $this->date_config = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $dd = $this->validate([
            'sucursal_destino_id' => 'required',
            'vehiculo_id' => 'required',
            'transportista_id' => 'required',
            'date_config' => 'required',
        ]);
        
        $aa = SucursalConfiguration::updateOrCreate([
            'sucursal_id' => Auth::user()->sucursal->id,
            'sucursal_destino_id' => $this->sucursal_destino_id],
            [
                'vehiculo_id' => $this->vehiculo_id,
                'transportista_id' => $this->transportista_id,
                'date_config' => $this->date_config,
                'isActive' => true]
        );
        //dd($aa,$this->transportista_id,$this->vehiculo_id);
        //$this->reset();
    }
}
