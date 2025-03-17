<?php

namespace App\Livewire\Home;

use App\Models\Package\Encomienda;
use DateTime;
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
        $this->dataChart(new DateTime(), 'year', Auth::user()->sucursal->id);
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
    public function dataChart(DateTime $date, $type = 'month', $sucursal_id = null)
    {
        //dd($date);
        $Y = $date->format('Y');
        $m = $date->format('m');
        $c = $date->format('d');

        // Get base query with branch office filter
        $query = Encomienda::query();

        // Filter by branch office if provided, otherwise use authenticated user's branch
        $query->where('sucursal_id', $sucursal_id ?? Auth::user()->sucursal->id);

        // Apply date filters and grouping based on type
        switch ($type) {
            case 'year':
                $data = $query->whereYear('created_at', $Y)
                    ->selectRaw('MONTH(created_at) as month, SUM(monto) as total_amount, COUNT(*) as count')
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
                break;

            case 'month':
                $data = $query->whereYear('created_at', $Y)
                    ->whereMonth('created_at', $m)
                    ->selectRaw('DAY(created_at) as day, SUM(monto) as total_amount, COUNT(*) as count')
                    ->groupBy('day')
                    ->orderBy('day')
                    ->get();
                break;

            default: // day
                $data = $query->whereYear('created_at', $Y)
                    ->whereMonth('created_at', $m)
                    ->whereDay('created_at', $c)
                    ->selectRaw('HOUR(created_at) as hour, SUM(monto) as total_amount, COUNT(*) as count')
                    ->groupBy('hour')
                    ->orderBy('hour')
                    ->get();
                break;
        }
        dd($data);
        return [
            'data' => $data,
            'totals' => [
                'amount' => $data->sum('total_amount'),
                'count' => $data->sum('count')
            ]
        ];
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
