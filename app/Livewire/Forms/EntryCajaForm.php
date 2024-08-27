<?php

namespace App\Livewire\Forms;

use App\Models\Caja\EntryCaja;
use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EntryCajaForm extends Form
{
    use LogCustom;

    #[Validate('required')]
    public $caja_id = '';
    #[Validate('required')]
    public $monto_entry = 0;
    #[Validate('required')]
    public $description = '';
    #[Validate('required')]
    public $tipo ='';
    public function store()
    {
        try {
            $this->validate();
            EntryCaja::create([
                'caja_id' => $this->caja_id,
                'monto_entry' => $this->monto_entry,
                'description' => $this->description,
                'tipo' => $this->tipo,
            ]);
            $this->infoLog('EntryCaja store');
            return true;
        } catch (\Exception $e) {
            $this->errorLog('EntryCaja store', $e);
            return false;
        }
    }
}
