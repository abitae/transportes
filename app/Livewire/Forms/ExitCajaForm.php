<?php

namespace App\Livewire\Forms;

use App\Models\Caja\ExitCaja;
use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ExitCajaForm extends Form
{
    use LogCustom;

    #[Validate('required')]
    public $caja_id = '';
    #[Validate('required')]
    public $monto_exit = 0;
    #[Validate('required')]
    public $description = '';
    #[Validate('required')]
    public $tipo = '';
    public function store()
    {
        try {
            $this->validate();
            ExitCaja::create([
                'caja_id' => $this->caja_id,
                'monto_exit' => $this->monto_exit,
                'description' => $this->description,
                'tipo' => $this->tipo,
            ]);
            $this->infoLog('ExitCaja store');
            return true;
        } catch (\Exception $e) {
            $this->errorLog('ExitCaja store', $e);
            return false;
        }
    }
}
