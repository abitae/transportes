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

class HomePackageLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Entrega paquetes destino';
    public $sub_title = 'Modulo de entrega de paquetes domicilio';
    public $search = '';
    public $perPage = 10;
    public $date_ini;
    public int $sucursal_id;
    public $date_traslado;
    public $numElementos;
    public Sucursal $sucursal_rem;
    public $modalDeliver = false;
    public $encomienda;
    public $document;
    public $pin;
    public $showDrawer;
    public $estado_pago;
    public $tipo_comprobante;
    public $caja;
    public bool $modalConfimation;
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
        $this->date_traslado = \Carbon\Carbon::now()->setTimezone('America/Lima')->format('Y-m-d');
        $this->tipo_comprobante = 3;
    }
    public function render()
    {
        $sucursals = Sucursal::where('isActive', true)->whereNot('id', [Auth::user()->sucursal->id])->get();
        $encomiendas = Encomienda::whereDate('created_at', $this->date_ini)
            ->where('sucursal_id', $this->sucursal_id)
            ->where('sucursal_dest_id', Auth::user()->sucursal->id)
            ->where('estado_encomienda', 'RECIBIDO')
            ->where('isHome', true)
            ->where(fn($query) => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
            )->paginate($this->perPage, '*', 'page');
        return view('livewire.package.home-package-live', compact('encomiendas', 'sucursals'));
    }
    public function detailEncomienda(Encomienda $encomienda)
    {
        $this->encomienda = $encomienda;
        $this->showDrawer = true;
    }

    public function openModal($id)
    {
        $this->modalDeliver = !$this->modalDeliver;
        $this->encomienda = Encomienda::find($id);
    }
    public function deliverPaquetes()
    {
        //dd($this->encomienda);
        if ($this->encomienda->isHome) {
            $this->pin = 123;
        }
        if ($this->encomienda->destinatario->code == $this->document and $this->encomienda->pin == $this->pin) {

            $this->customerFact->setCustomer($this->encomienda->destinatario);
            $this->estado_pago = $this->encomienda->estado_pago;
            $this->modalDeliver = false;
            $this->modalConfimation = true;
        } else {

        }
    }
    public function confirmEncomienda()
    {
        try {
            $envio = $this->encomienda;
            $this->encomienda->update(
                ['estado_encomienda' => 'ENTREGADO']
            );
            $this->modalConfimation = false;
        } catch (\Throwable $th) {
            $this->error('Error, verifique los datos!');
            return 0;
        }

    }
}
