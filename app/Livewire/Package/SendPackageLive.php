<?php
namespace App\Livewire\Package;

use App\Exports\ManifiestoExport;
use App\Livewire\Forms\CustomerForm;
use App\Models\Configuration\Sucursal;
use App\Models\Configuration\SucursalConfiguration;
use App\Models\Configuration\Transportista;
use App\Models\Configuration\Vehiculo;
use App\Models\Package\Customer;
use App\Models\Package\Encomienda;
use App\Models\Package\Manifiesto;
use App\Models\Package\Paquete;
use App\Services\ServiceTableSunat;
use App\Traits\CajaTrait;
use App\Traits\LogCustom;
use App\Traits\UtilsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Mary\Traits\Toast;

class SendPackageLive extends Component
{
    use LogCustom, Toast, WithPagination, WithoutUrlPagination;
    use CajaTrait, UtilsTrait;
    public $title = 'ENVIAR PAQUETES';
    public $sub_title = 'Modulo de envio de paquetes';
    public $search = '';
    public $perPage = 100;
    public array $selected = [];
    public int $sucursal_dest_id = 0;
    public $date_ini;
    public $date_fin;
    public $modalEnvio = false;
    public $numElementos;
    public Sucursal $sucursal_dest;
    public $transportista_id = 1;
    public $vehiculo_id = 1;
    public $isActive = true;
    public bool $showDrawer = false;
    public Encomienda $encomienda;
    public $editModal = false;
    public $isHome = false;
    public CustomerForm $customerFormDest;
    public $modalFinal;
    public $manifiesto;
    public $date_traslado;
    public $editEncomiendaModal = false;
    public $paquetes;
    public $destinatario_code;
    public $destinatario_type_code;
    public $destinatario_name;
    public $destinatario_address;
    public $destinatario_phone;
    public $destinatario_ubigeo;
    public $destinatario;
    public $und_medida = 'NIU';
    public $description;
    public $peso;
    public $amount;
    public $cantidad;
    public function mount()
    {
        $this->date_traslado = Carbon::now()->endOfDay()->format('Y-m-d H:i');
        $this->date_ini = Carbon::now()->startOfDay()->format('Y-m-d H:i');//$this->dateNow('Y-m-d');
        $this->date_fin = $this->dateNow('Y-m-d H:i:s');

        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        if ($p->isEmpty()) {
            return redirect()->route('caja.index');
        }

        $this->sucursal_dest_id = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->first()
            ->id;
        $this->paquetes = collect([])->keyBy('id');
    }
    public function render()
    {
        $p = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->pluck('sucursal_destino_id');

        $sucursals = Sucursal::where('isActive', true)
            ->whereIn('id', $p)
            ->get();

        $config = SucursalConfiguration::where('isActive', true)
            ->where('sucursal_id', Auth::user()->sucursal->id)
            ->where('sucursal_destino_id', $this->sucursal_dest_id)
            ->first();

        $this->transportista_id = $config->transportista_id;
        $this->vehiculo_id = $config->vehiculo_id;

        // Build base query with date range filter
        $encomiendas = Encomienda::query()
            ->when($this->date_ini && $this->date_fin, function($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->date_ini)->startOfDay(),
                    Carbon::parse($this->date_fin)->endOfDay()
                ]);
            })
            ->where([
                'isActive' => $this->isActive,
                'sucursal_id' => Auth::user()->sucursal->id,
                'sucursal_dest_id' => $this->sucursal_dest_id,
            ])
            ->whereIn('estado_encomienda' , ['REGISTRADO','RETORNADO'])
            // Search in related models and package code
            ->when($this->search, function($query) {
                $searchTerm = '%' . $this->search . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('remitente', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    })
                    ->orWhere('code', 'like', $searchTerm)
                    ->orWhereHas('destinatario', function($subQuery) use ($searchTerm) {
                        $subQuery->where('code', 'like', $searchTerm)
                                ->orWhere('name', 'like', $searchTerm);
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage, ['*'], 'page');

        $transportistas = Transportista::where('isActive', true)->get();
        $vehiculos = Vehiculo::where('isActive', true)->get();
        $service = new ServiceTableSunat();
        $unidadMedidas = $service->getAll('sunat_03');
        $metodoPagos = [
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Yape', 'name' => 'Yape'],
            ['id' => 'Transferencia', 'name' => 'Transferencia'],
            ['id' => 'Deposito', 'name' => 'Deposito'],
        ];
        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad'],
            ['key' => 'und_medida', 'label' => 'Unidad'],
            ['key' => 'description', 'label' => 'Descripcion'],
            ['key' => 'peso', 'label' => 'Peso'],
            ['key' => 'amount', 'label' => 'P.UNIT'],
            ['key' => 'sub_total', 'label' => 'MONTO'],
        ];
        return view('livewire.package.send-package-live', compact(
            'encomiendas',
            'sucursals',
            'transportistas',
            'vehiculos',
            'unidadMedidas',
            'metodoPagos',
            'headers_paquetes'
        ));
    }
    public function openModal()
    {
        if (!empty($this->selected)) {
            $this->numElementos = count($this->selected);
            $this->sucursal_dest = Sucursal::findOrFail($this->sucursal_dest_id);
            $this->modalEnvio = !$this->modalEnvio;
        } else {
            $this->error('Seleccione al menos un paquete!');
        }
    }
    public function sendPaquetes()
    {
        if ($this->vehiculo_id && $this->transportista_id) {
            $vehiculo_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->vehiculo_id;
            $transportista_id = Encomienda::where('isActive', true)
                ->whereIn('id', $this->selected)->first()->transportista_id;
            if ($vehiculo_id != $this->vehiculo_id || $transportista_id != $this->transportista_id) {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                        'isTransbordo' => true,
                        'fecha_envio' => Carbon::now(),
                    ]);
            } else {
                $num_encomiendas_enviadas = Encomienda::where('isActive', true)
                    ->whereIn('id', $this->selected)
                    ->update([
                        'estado_encomienda' => 'ENVIADO',
                        'fecha_envio' => Carbon::now(),
                        'vehiculo_id' => $this->vehiculo_id,
                        'transportista_id' => $this->transportista_id,
                    ]);
            }
            if (count($this->selected) == $num_encomiendas_enviadas) {
                $this->success('Genial, enviado correctamente!');
                $this->modalEnvio = false;
                $ids = $this->selected;
                $this->selected = [];
                $this->manifiesto = Manifiesto::create([
                    'sucursal_id' => Auth::user()->sucursal->id,
                    'sucursal_destino_id' => $this->sucursal_dest_id,
                    'ids' => json_encode($ids),
                ]);
                SucursalConfiguration::where('sucursal_id', Auth::user()->sucursal->id)
                    ->where('sucursal_destino_id', $this->sucursal_dest_id)
                    ->update(['isActive' => false]);

                $p = SucursalConfiguration::where('isActive', true)
                    ->where('sucursal_id', Auth::user()->sucursal->id)
                    ->pluck('sucursal_destino_id');
                if ($p->isEmpty()) {
                    return redirect()->route('package.manifiesto');
                } else {
                    $this->sucursal_dest_id = Sucursal::where('isActive', true)
                        ->whereIn('id', $p)
                        ->first()
                        ->id;
                }
                $this->modalFinal = true;
            } else {
                $this->error('Error, verifique los datos!');
            }
        } else {
            $this->error('Seleccione un vehiculo y transportista!');
        }
    }
    public function enableEncomienda(Encomienda $encomienda)
    {
        try {
            $encomienda->isActive = !$encomienda->isActive;
            $encomienda->save();
            $this->success('Genial, ingresado correctamente!');
        } catch (\Exception $e) {
            $this->error('Error, verifique los datos!');
        }
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }
    public function editEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->editEncomiendaModal = true;
        $this->paquetes = $encomienda->paquetes;
        $this->paquetes = $this->paquetes->map(function($paquete) {
            $paquete->amount = number_format($paquete->amount, 2, '.', '');
            return $paquete;
        });
        $this->destinatario_code = $encomienda->destinatario->code;
        $this->destinatario_type_code = $encomienda->destinatario->type_code;
        $this->destinatario_name = $encomienda->destinatario->name;
        $this->destinatario_address = $encomienda->destinatario->address;
        $this->destinatario_phone = $encomienda->destinatario->phone;
        $this->isHome = $encomienda->isHome;
    }
    public function updateEncomienda()
    {
        if ($this->customerFormDest->code && $this->customerFormDest->type_code) {
            $this->encomienda->customer_dest_id = Customer::where('code', $this->customerFormDest->code)
                ->where('type_code', $this->customerFormDest->type_code)
                ->first()
                ->id;

            $this->encomienda->isHome = $this->isHome;
            $this->customerFormDest->update();
            $this->encomienda->save();
            $this->editModal = false;
        }
    }
    public function excelGenerate(Manifiesto $manifiesto)
    {
        $this->toast('success', 'Generando Excel', 'Manifiesto');
        $this->modalFinal = false;
        return Excel::download(new ManifiestoExport(json_decode($manifiesto->ids)), 'manifiesto.xlsx');
    }
    public function searchDestinatario()
    {
        $rules = [
            'destinatario_type_code' => 'required',
            'destinatario_code' => 'required|min:8|max:11',
        ];
        $messages = [
            'destinatario_type_code.required' => 'El tipo de documento es requerido',
            'destinatario_code.required' => 'El número de documento es requerido',
            'destinatario_code.min' => 'El número de documento debe tener 8 dígitos',
            'destinatario_code.max' => 'El número de documento debe tener 11 dígitos',
        ];
        //dd($this->destinatario_type_code);
        $this->validate($rules, $messages);
        $destinatario = Customer::where('type_code', $this->destinatario_type_code)
            ->where('code', $this->destinatario_code)
            ->first();
        //dd($destinatario);
        if ($destinatario) {
            $this->destinatario = $destinatario;
            $this->destinatario_name = $destinatario->name;
            $this->destinatario_address = $destinatario->address;
            $this->destinatario_phone = $destinatario->phone;
            $this->destinatario_ubigeo = $destinatario->ubigeo;
            return;
        }
        $tipo = $this->destinatario_type_code == '6' ? 'ruc' : 'dni';
        $respuesta = $this->searchComplete($tipo, $this->destinatario_code);

        if (!$respuesta['encontrado']) {
            $this->destinatario_name = '';
            $this->destinatario_address = '';
            $this->destinatario_phone = '';
            $this->destinatario_ubigeo = '';
            $this->error('El destinatario no existe!, verifique el número de documento!');
            return;
        }
        if ($tipo == 'ruc') {
            $this->destinatario_name = $respuesta['data']->razon_social;
            $this->destinatario_address = $respuesta['data']->direccion;
            $this->destinatario_ubigeo = $respuesta['data']->codigo_ubigeo;
        } else {
            $this->destinatario_name = $respuesta['data']->nombre;
            $this->destinatario_phone = '';
            $this->destinatario_ubigeo = '';
        }

        $this->destinatario = Customer::firstOrCreate(
            [
                'type_code' => $this->destinatario_type_code,
                'code' => $this->destinatario_code
            ],
            [
                'name' => $this->destinatario_name,
                'address' => $this->destinatario_address,
                'ubigeo' => $this->destinatario_ubigeo
            ]
        );
    }
    public function addPaquete()
    {
        $rules = [
            'cantidad' => 'required|numeric',
            'und_medida' => 'required',
            'description' => 'required',
            'peso' => 'required|numeric',
            'amount' => 'required|numeric',
        ];
        $messages = [
            'cantidad.required' => 'Error, es necesario ingresar la cantidad!',
            'cantidad.numeric' => 'Error, la cantidad debe ser un número!',
            'und_medida.required' => 'Error, es necesario ingresar la unidad de medida!',
            'description.required' => 'Error, es necesario ingresar la descripción!',
            'peso.required' => 'Error, es necesario ingresar el peso!',
            'peso.numeric' => 'Error, el peso debe ser un número!',
            'amount.required' => 'Error, es necesario ingresar el precio unitario!',
            'amount.numeric' => 'Error, el precio unitario debe ser un número!',
        ];
        $this->validate($rules, $messages);
        $paquete = new Paquete();
        $paquete->id = $this->paquetes->count() + 1;
        $paquete->encomienda_id = $this->encomienda->id;
        $paquete->cantidad = $this->cantidad;
        $paquete->und_medida = $this->und_medida;
        $paquete->description = $this->description;
        $paquete->peso = $this->peso;
        $paquete->amount = $this->amount;
        $paquete->sub_total = $this->amount * $this->cantidad;
        //dd($this->paquetes);
        $this->paquetes->push($paquete->toArray());
        $this->success('Genial', 'Paquete ingresado correctamente!');
    }
    public function restPaquete($id)
    {
        $this->success('Genial', 'Paquete eliminado correctamente!');
        $this->paquetes->pull($id - 1);
    }

    public function resetPaquete()
    {
        $this->success('Genial', 'Paquetes eliminados correctamente!');
        $this->paquetes = collect([]);
    }
}
