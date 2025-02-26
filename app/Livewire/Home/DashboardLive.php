<?php

namespace App\Livewire\Home;

use App\Models\Package\Encomienda;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardLive extends Component
{
    public string $title = 'Dashboard';
    public string $sub_title = 'Estadistica';
    public array $myChart = [
        'type' => 'bar',
        'data' => [],
    ];
    public array $myLine = [
        'type' => 'line',
        'data' => [],
    ];
    public function mount()
    {
        $labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $encomiendas = Encomienda::where('sucursal_id', Auth::user()->sucursal->id)
        ->where('created_at', 2025)
        ->count();
        $datasets = [
            [
                'label' => 'Encomiendas',
                'data' => [12, 19, 3],
            ],
            [
                'label' => 'Encomiendas',
                'data' => [1, 9, 3],
            ],
        ];

        Arr::set($this->myChart['data'], 'labels', $labels);
        Arr::set($this->myChart['data'], 'datasets', $datasets);
        Arr::set($this->myLine['data'], 'labels', $labels);
        Arr::set($this->myLine['data'], 'datasets', $datasets);
    }
    public function render()
    {
        return view('livewire.home.dashboard-live');
    }
    public function switch()
    {

            $type = $this->myChart['type'] == 'bar' ? 'pie' : 'bar';
            Arr::set($this->myChart, 'type', $type);
    }
}
