<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
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
    public int $step = 3;
    public $title = 'Registro';
    public $sub_title = 'Registrar paquetes de envio';

    public CustomerForm $customerForm, $customerFormDest;

    public $cantidad;
    public $description;
    public $peso;
    public $amount;

    public $paquetes;
    public $paquetesPro;
    public function mount()
    {
        $this->paquetes = collect([]);
    }
    public function render()
    {
        $docs = [
            ['id' => 'dni', 'name' => 'DNI'],
            ['id' => 'ruc', 'name' => 'RUC'],
            ['id' => 'ce', 'name' => 'CE'],
        ];

        $headers_paquetes = [
            ['key' => 'cantidad', 'label' => 'Cantidad', 'class' => ''],
            ['key' => 'description', 'label' => 'Descripcion', 'class' => ''],
            ['key' => 'peso', 'label' => 'Peso', 'class' => ''],
            ['key' => 'amount', 'label' => 'Monto', 'class' => ''],
            ['key' => 'actions', 'label' => 'Accion', 'class' => ''],
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
        return view('livewire.package.register-live', compact('docs', 'headers_paquetes', 'pagos', 'comprobantes'));
    }
    public function searchRemitente()
    {
        $this->customerForm->store();
    }
    public function searchDestinatario()
    {
        $this->customerFormDest->store();
    }
    public function next()
    {
        if ($this->step < 4) {
            switch ($this->step) {
                case 1:
                    if ($this->customerForm->update()) {
                        $this->step++;
                        $this->toast('Remitente registrado correctamente.', 'success');
                    }
                    break;
                case 2:
                    if ($this->customerForm->update()) {
                        $this->step++;
                        $this->toast('Destinatario registrado correctamente.', 'success');
                    }
                    break;
                case 3:
                    $this->step++;
                    $this->toast('3 registrado correctamente.', 'success');
                    break;
                case 4:
                    $this->toast('3 registrado correctamente.', 'success');
                    break;
            }
        }
    }
    public function prev()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }
    public function addPaquete()
    {
        $this->paquetes->push([
            'cantidad' => $this->cantidad,
            'description' => $this->description,
            'peso' => $this->peso,
            'amount' => $this->amount,
        ]);
        //dump($this->paquetes->toArray());
    }
    public function save()
    {
        $paquetes = $this->paquetes;
        foreach ($paquetes as $paquete) {
            $this->paquetes->push(collect($paquete)->put('encomienda_id', 1));
        }
        dump($this->paquetes->all());
        //Paquete::upsert($this->paquetes->toArray(), null, null);
    }
}
