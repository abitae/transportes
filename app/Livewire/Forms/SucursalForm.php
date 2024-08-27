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
    #[Validate('required')]
    public $name = '';
    #[Validate('required')]
    public $address = '';
    #[Validate('required')]
    public $phone = '';
    #[Validate('required|email')]
    public $email = '';
    public function setSucursal(Sucursal $sucursal)
    {
        $this->sucursal = $sucursal;
        $this->name = $sucursal->name;
        $this->address = $sucursal->address;
        $this->phone = $sucursal->phone;
        $this->email = $sucursal->email;
    }
    public function store()
    {
        try {
            $this->validate();
            Sucursal::create([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);
            $this->infoLog('Sucursal store ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->validate();
            $this->sucursal->update([
                'name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
            ]);
            $this->infoLog('Sucursal update ' . Auth::user()->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal update', $e);
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
            $sucursal->update([
                'isActive' => !$sucursal->isActive,
            ]);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Sucursal delete', $e);
            return false;
        }
    }
}
