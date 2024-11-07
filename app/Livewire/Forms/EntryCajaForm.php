<?php

namespace App\Livewire\Forms;

use App\Traits\CajaTrait;
use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EntryCajaForm extends Form
{
    use LogCustom;
    use CajaTrait;

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
            $this->cajaEntry($this->caja_id,$this->monto_entry,$this->description,$this->tipo);
            $this->infoLog('EntryCaja store');
            return true;
        } catch (\Exception $e) {
            $this->errorLog('EntryCaja store', $e);
            return false;
        }
    }
}
