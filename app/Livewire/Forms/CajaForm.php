<?php

namespace App\Livewire\Forms;

use App\Models\Caja\Caja;
use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CajaForm extends Form
{
    use LogCustom;

    #[Validate('required')]
    public $monto_apertura = 0;
    public $monto_cierre = 0;

    public function store()
    {
        try {
            $caja = Caja::create([
                'user_id' => 1,
                'monto_apertura' => $this->monto_apertura,
                'monto_cierre' => 0,
                'isActive' => true,
            ]);
            $this->infoLog('Caja store');
            return $caja;
        } catch (\Exception $e) {
            $this->errorLog('Caja store', $e);
            return null;
        }
    }
    public function update(Caja $caja)
    {
        try {
            $caja->update([
                'monto_cierre' => $this->monto_cierre,
                'isActive' => false,
            ]);
            $this->infoLog('Caja store');
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Caja store', $e);
            return false;
        }
    }
}
