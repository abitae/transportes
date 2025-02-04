<?php
namespace App\Livewire\Caja;

use App\Livewire\Forms\CajaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
use App\Models\Caja\Caja;
use App\Traits\CajaTrait;
use App\Traits\UtilsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class CajaLive extends Component
{
    use Toast, CajaTrait, UtilsTrait, WithPagination, WithoutUrlPagination;

    public CajaForm $cajaForm;
    public EntryCajaForm $entryForm;
    public ExitCajaForm $exitForm;
    public string $title     = 'Caja';
    public string $sub_title = 'Modulo de caja';

    public bool $showHistory = false;
    public bool $openCaja    = false;
    public bool $modalCaja   = false;
    public bool $modalEntry  = false;
    public bool $modalExit   = false;

    public $fechaActual;
    public $caja;
    public int $perPage = 10;

    public function mount()
    {
        $this->fechaActual = $this->dateNow('Y-m-d');
        $this->caja        = $this->cajaIsActive(Auth::user());
        $this->openCaja    = (bool) $this->caja;
    }

    public function render()
    {
        $headersIngreso = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1'],
            ['key' => 'tipo', 'label' => 'Tipo', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
            ['key' => 'monto_entry', 'label' => 'Monto', 'class' => ''],
        ];
        $headersEgreso = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-red-500 w-1'],
            ['key' => 'tipo', 'label' => 'Tipo', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripción', 'class' => ''],
            ['key' => 'monto_exit', 'label' => 'Monto', 'class' => ''],
        ];
        $tipos = [
            ['id' => 'Devolucion', 'name' => 'Devolución'],
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Ticket', 'name' => 'Ticket'],
        ];
        $tipos2 = [
            ['id' => 'Devolucion', 'name' => 'Pago'],
            ['id' => 'Efectivo', 'name' => 'Efectivo'],
            ['id' => 'Ticket', 'name' => 'Ticket'],
        ];
        $headersHistory = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-blue-500 w-1 text-black'],
            ['key' => 'created_at', 'label' => 'Fecha Apertura', 'class' => 'text-black'],
            ['key' => 'updated_at', 'label' => 'Fecha Cierre', 'class' => 'text-black'],
            ['key' => 'monto_apertura', 'label' => 'Apertura', 'class' => 'bg-green-500 text-black'],
            ['key' => 'monto_cierre', 'label' => 'Cierre', 'class' => 'bg-red-500 text-black'],
            ['key' => 'action', 'label' => 'Imprimir', 'class' => ''],
        ];
        $cajas = $this->cajaListPaginate(Auth::user(), $this->perPage);
        return view('livewire.caja.caja-live', compact('cajas', 'headersHistory', 'headersIngreso', 'headersEgreso', 'tipos', 'tipos2'));
    }

    public function openModal()
    {
        $this->cajaForm->reset();
        $this->modalCaja = true;
    }

    public function save()
    {
        if ($this->openCaja) {
            $this->updateCaja();
        } else {
            $this->storeCaja();
        }
    }

    private function updateCaja()
    {
        if ($this->cajaForm->update($this->caja) && $this->cajaForm->monto_cierre == ($this->caja->monto_apertura + $this->caja->entries->sum('monto_entry') - $this->caja->exits->sum('monto_exit'))) {
            $this->success('Genial, actualizado correctamente!');
            $this->modalCaja = false;
            $this->openCaja  = false;
        } else {
            $this->error('Error, verifique los datos!');
        }
    }

    private function storeCaja()
    {
        $this->caja = $this->cajaForm->store();
        if ($this->caja) {
            $this->success('Genial, guardado correctamente!');
            $this->modalCaja = false;
            $this->openCaja  = true;
        } else {
            $this->error('Error, verifique los datos!');
            $this->modalEntry = false;
        }
    }

    public function entryCaja()
    {
        if ($this->openCaja) {
            $this->entryForm->caja_id = $this->caja->id;
            if ($this->entryForm->store()) {
                $this->success('Genial, ingresado correctamente!');
                $this->modalEntry = false;
                $this->entryForm->reset();
            } else {
                $this->error('Error, verifique los datos!');
                $this->modalEntry = false;
            }
        }
    }

    public function exitCaja()
    {
        if ($this->openCaja) {
            $this->exitForm->caja_id = $this->caja->id;
            if ($this->exitForm->store()) {
                $this->success('Genial, ingresado correctamente!');
                $this->modalExit = false;
                $this->exitForm->reset();
            } else {
                $this->error('Error, verifique los datos!');
                $this->modalExit = false;
            }
        }
    }

    public function printCaja(Caja $caja)
    {
        return $this->cajaPrint($caja);
    }
}
