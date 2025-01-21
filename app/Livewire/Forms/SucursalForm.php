<?php

namespace App\Livewire\Forms;

use App\Models\Configuration\Sucursal;
use App\Traits\LogCustom;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SucursalForm extends Form
{
    use LogCustom;

    public ?Sucursal $sucursal = null;
    #[Validate('required|max:3')]
    public $code = '';
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $serie = '';
    #[Validate('required')]
    public $color = '';
    #[Validate('required')]
    public $address = '';
    #[Validate('required')]
    public $phone = '';
    #[Validate('required|email')]
    public $email = '';

    public function setSucursal(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->fill($sucursal->toArray());
    }

    public function store()
    {
        return $this->saveSucursal(new Sucursal());
    }

    public function update()
    {
        return $this->saveSucursal($this->sucursal);
    }

    private function saveSucursal(Sucursal $sucursal)
    {
        try {
            $this->validate();
            $sucursal->fill($this->validate())->save();
            $this->infoLog('Sucursal ' . ($sucursal->exists ? 'update' : 'store') . ' ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal ' . ($sucursal->exists ? 'update' : 'store'), $e);
            return false;
        }
    }

    public function delete(Sucursal $sucursal)
    {
        try {
            $sucursal->delete();
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal delete', $e);
            return false;
        }
    }

    public function estado(Sucursal $sucursal)
    {
        try {
            $sucursal->update(['isActive' => !$sucursal->isActive]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal estado', $e);
            return false;
        }
    }
}
