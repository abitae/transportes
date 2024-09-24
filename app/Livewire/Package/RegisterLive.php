<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\User;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class RegisterLive extends Component
{
    use LogCustom;
    use SearchDocument;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public int $step = 1;
    public $title = 'Registro';
    public $sub_title = 'Registrar paquetes de envio';

    public CustomerForm $customerForm;

    public function render()
    {
        $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
        ];
        $users2 = User::all();

        $headers2 = [
            ['key' => 'id', 'label' => '#', 'class' => 'bg-green-500 w-1 text-black'],
            ['key' => 'name', 'label' => 'Nice Name', 'class' => 'text-green-500'],
            ['key' => 'email', 'label' => 'Email', 'class' => 'text-green-500'],
        ];
        $pagos = [
            ['id' => 1, 'name' => 'PAGADO'],
            ['id' => 2, 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 1, 'name' => 'BOLETA'],
            ['id' => 2, 'name' => 'FACTURA'],
            ['id' => 3, 'name' => 'TICKET'],
        ];
        return view('livewire.package.register-live', compact('docs', 'users2', 'headers2', 'pagos', 'comprobantes'));
    }
    public function searchDocument()
    {
        $this->customerForm->store();
    }
    public function next()
    {
        if ($this->step < 4) {
            $this->step++;
        }
    }
    public function prev()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
}
