<?php

namespace App\Livewire\Caja;

use App\Livewire\Forms\CajaForm;
use App\Livewire\Forms\EntryCajaForm;
use App\Livewire\Forms\ExitCajaForm;
use App\Models\Caja\Caja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class CajaLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public CajaForm $cajaForm;
    public EntryCajaForm $entryForm;
    public ExitCajaForm $exitForm;
    public string $title = 'Caja';
    public string $sub_title = 'Modulo de caja';

    public bool $showHistory = false; //caja inicial cerrada
    public bool $openCaja = false; //caja inicial cerrada
    public bool $modalCaja = false; //modal cerrado
    public bool $modalEntry = false; //modal cerrado
    public bool $modalExit = false; //modal cerrado

    public $fechaActual;
    public $caja;
    public int $perPage = 10;
    public function mount()
    {
        $this->caja = Caja::where('user_id', Auth::user()->id)
            ->where('isActive', true)
            ->latest()->first();
        if ($this->caja) {
            $this->openCaja = true;
        }
    }
    public function render()
    {
        $cajas = Caja::where('user_id', Auth::user()->id)
            ->latest()->paginate($this->perPage);
        $this->fechaActual = Carbon::now()->format('Y-m-d');
        return view('livewire.caja.caja-live',compact('cajas'));
    }
    public function openModal()
    {
        $this->cajaForm->reset();
        $this->modalCaja = true;
    }
    public function save()
    {
        if ($this->openCaja) {
            if ($this->cajaForm->update($this->caja) and $this->cajaForm->monto_cierre == ($this->caja->entries->sum('monto_entry') - $this->caja->exits->sum('monto_exit'))) {
                $this->success('Genial, actualizado correctamente!');
                $this->modalCaja = false;
                $this->openCaja = false;
            } else {
                $this->error('Error, verifique los datos!');
            }
        } else {
            $this->caja = $this->cajaForm->store();
            if ($this->caja) {
                $this->success('Genial, guardado correctamente!');
                $this->modalCaja = false;
                $this->openCaja = true;
            } else {
                $this->error('Error, verifique los datos!');
                $this->modalEntry = false;
            }
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
}
