<?php

namespace App\Livewire\Home;

use App\Models\Configuration\Sucursal;
use App\Models\Package\Encomienda;
use DateTime;
use Illuminate\Support\Arr;
use Livewire\Component;

class DashboardLive extends Component
{
    public string $title = 'DASHBOARD';
    public string $sub_title = 'Estadistica';
    public array $myChart = [
        'type' => 'bar',
        'data' => [],
    ];
    public array $myLine = [
        'type' => 'line',
        'data' => [],
        'option' => [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Chart.js Bar Chart'
                ]
            ]
        ],
    ];
    public array $myPie = [
        'type' => 'pie',
        'data' => [],
        'option' => [
            'responsive' => true,
        ],
    ];
    public array $myBar = [
        'type' => 'bar',
        'data' => [],
        'option' => [
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Chart.js Bar Chart'
                ]
            ]
        ],
    ];
    public $selectedTipe = 'Y';

    private function dataChartYear(DateTime $date)
    {
        return $this->getChartData($date, 'year');
    }

    private function dataChartMonth(DateTime $date)
    {
        return $this->getChartData($date, 'month');
    }

    private function dataChartDay(DateTime $date)
    {
        return $this->getChartData($date, 'day');
    }
    private function getChartData(DateTime $date, string $timeUnit = 'month')
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        $timeConfigs = [
            'year' => [
                'size' => 12,
                'start' => 1,
                'format' => 'MONTH',
                'labels' => [
                    'Enero',
                    'Febrero',
                    'Marzo',
                    'Abril',
                    'Mayo',
                    'Junio',
                    'Julio',
                    'Agosto',
                    'Septiembre',
                    'Octubre',
                    'Noviembre',
                    'Diciembre'
                ]
            ],
            'month' => [
                'size' => $date->format('t'),
                'start' => 1,
                'format' => 'DAY',
                'where' => ['whereMonth' => $month]
            ],
            'day' => [
                'size' => 24,
                'start' => 0,
                'format' => 'HOUR',
                'where' => ['whereMonth' => $month, 'whereDay' => $day]
            ]
        ];

        $config = $timeConfigs[$timeUnit];
        $datasets = [];
        $sucursals = Sucursal::all();

        foreach ($sucursals as $sucursal) {
            $periodData = array_fill($config['start'], $config['size'], 0);

            $query = Encomienda::where('sucursal_id', $sucursal->id)
                ->whereYear('created_at', $year);

            // Apply additional where clauses if they exist
            if (isset($config['where'])) {
                foreach ($config['where'] as $method => $value) {
                    $query->$method('created_at', $value);
                }
            }

            $data = $query->selectRaw(
                $config['format'] . "(created_at) as period, 
                    SUM(monto) as total_amount"
            )
                ->groupBy('period')
                ->orderBy('period')
                ->get();

            foreach ($data as $record) {
                $periodData[$record->period] = $record->total_amount;
            }

            $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $datasets[] = [
                'label' => $sucursal->code,
                'data' => array_values($periodData),
                'borderColor' => $color,
                'backgroundColor' => $color,
            ];
        }

        return [
            'labels' => $timeUnit === 'year' ? $config['labels'] : range($config['start'], $config['size'] - 1 + $config['start']),
            'datasets' => $datasets
        ];
    }
    private function dataPieYear(DateTime $date)
    {
        return $this->getPieData($date, 'year');
    }
    private function dataPieMonth(DateTime $date)
    {
        return $this->getPieData($date, 'month');
    }
    private function dataPieDay(DateTime $date)
    {
        return $this->getPieData($date, 'day');
    }
    private function getPieData(DateTime $date, string $timeUnit = 'month')
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        // Time period filters configuration
        $timeConfigs = [
            'year' => [],
            'month' => ['whereMonth' => $month],
            'day' => ['whereMonth' => $month, 'whereDay' => $day]
        ];

        $config = $timeConfigs[$timeUnit] ?? [];
        
        // Get all payment data in a single query
        $query = Encomienda::selectRaw('
                sucursal_id,
                tipo_pago,
                SUM(monto) as total_amount
            ')
            ->whereYear('created_at', $year)
            ->whereIn('tipo_pago', ['Contado', 'Credito']);

        // Apply time-specific filters
        foreach ($config as $method => $value) {
            $query->$method('created_at', $value);
        }

        $results = $query->groupBy('sucursal_id', 'tipo_pago')
            ->get();

        // Prepare data structure
        $sucursals = Sucursal::all();
        $datasets = [];
        $totalData = [];

        // Process results into required format
        foreach ($sucursals as $sucursal) {
            $contado = $results->where('sucursal_id', $sucursal->id)
                ->where('tipo_pago', 'Contado')
                ->first();
            
            $credito = $results->where('sucursal_id', $sucursal->id)
                ->where('tipo_pago', 'Credito')
                ->first();

            // Generate consistent colors for better visualization
            $color1 = sprintf('rgba(%d, %d, %d, 0.8)', mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            $color2 = sprintf('rgba(%d, %d, %d, 0.8)', mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));

            $datasets[] = [
                'data' => [
                    $contado ? $contado->total_amount : 0,
                    $credito ? $credito->total_amount : 0
                ],
                'backgroundColor' => [$color1, $color2],
                'hoverBackgroundColor' => [$color1, $color2],
                'label' => $sucursal->code,
                'borderWidth' => 1,
                'borderColor' => 'rgba(255, 255, 255, 0.8)'
            ];
        }

        return [
            'labels' => ['Contado', 'Crédito'],
            'datasets' => $datasets
        ];
    }
    
    private function dataBarYear(DateTime $date)
    {
        $year = $date->format('Y');
        return $this->getBarData($year);
    }
    private function dataBarMonth(DateTime $date)
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        return $this->getBarData($year, $month);
    }
    private function dataBarDay(DateTime $date)
    {
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        return $this->getBarData($year, $month, $day);
    }
    private function getBarData($year, $month = null, $day = null)
    {
        $labels = [];
        $datasets = [];
        $sucursals = Sucursal::all();
        $estados = ['REGISTRADO', 'ENVIADO', 'RECIBIDO' ,'RETORNADO', 'ENTREGADO'];

        // Initialize data array for all statuses
        $labels = [];
        foreach ($sucursals as $sucursal) {
            $labels[$sucursal->code] = array_fill_keys($estados, 0);
        }

        // Get shipment counts by status for each branch
        foreach ($sucursals as $sucursal) {
            $query = Encomienda::where('sucursal_id', $sucursal->id)
                ->whereYear('created_at', $year);

            if ($month) {
                $query->whereMonth('created_at', $month);
            }
            if ($day) {
                $query->whereDay('created_at', $day);
            }

            $data = $query->selectRaw('estado_encomienda, COUNT(*) as total')
                ->groupBy('estado_encomienda')
                ->get();

            foreach ($data as $record) {
                $labels[$sucursal->code][$record->estado_encomienda] = $record->total;
            }
        }

        // Prepare datasets for each status
        foreach ($estados as $index => $estado) {
            $backgroundColor = sprintf(
                'rgba(%d, %d, %d, 0.8)',
                mt_rand(0, 255),
                mt_rand(0, 255),
                mt_rand(0, 255)
            );

            $dataset = [
                'label' => $estado,
                'data' => array_map(function ($branchData) use ($estado) {
                    return $branchData[$estado];
                }, $labels),
                'backgroundColor' => $backgroundColor,
                'borderColor' => $backgroundColor,
                'borderRadius' => 5,
                'borderWidth' => 1
            ];

            $datasets[] = $dataset;
        }

        return [
            'labels' => array_keys($labels),
            'datasets' => $datasets
        ];
    }
    public function render()
    {
        switch ($this->selectedTipe) {
            case 'Y':
                $data = $this->dataChartYear(new DateTime());
                $dataPie = $this->dataPieYear(new DateTime());
                $dataBar = $this->dataBarYear(new DateTime());
                break;
            case 'm':
                $data = $this->dataChartMonth(new DateTime());
                $dataPie = $this->dataPieMonth(new DateTime());
                $dataBar = $this->dataBarMonth(new DateTime());
                break;
            case 'd':
                $data = $this->dataChartDay(new DateTime());
                $dataPie = $this->dataPieDay(new DateTime());
                $dataBar = $this->dataBarDay(new DateTime());
                break;
            default:
                $data = $this->dataChartMonth(new DateTime());
                $dataPie = $this->dataPieMonth(new DateTime());
                $dataBar = $this->dataBarMonth(new DateTime());
                break;
        }

        Arr::set($this->myLine['data'], 'labels', $data['labels']);
        Arr::set($this->myLine['data'], 'datasets', $data['datasets']);

        Arr::set($this->myPie['data'], 'labels', $dataPie['labels']);
        Arr::set($this->myPie['data'], 'datasets', $dataPie['datasets']);

        Arr::set($this->myBar['data'], 'labels', $dataBar['labels']);
        Arr::set($this->myBar['data'], 'datasets', $dataBar['datasets']);

        return view('livewire.home.dashboard-live');
    }
    public function switch()
    {

        $type = $this->myChart['type'] == 'bar' ? 'pie' : 'bar';
        Arr::set($this->myChart, 'type', $type);
    }
}
