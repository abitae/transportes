<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\Configuration\Sucursal;
use App\Models\Package\Paquete;
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

    public CustomerForm $customerForm, $customerFormDest;

    public $cantidad;
    public $description;
    public $peso;
    public $amount;

    public $paquetes;
    public $sucursal_dest_id;
    public $pin1;
    public $pin2;
    public $doc_traslado;
    public $glosa;
    public $modalConfimation = false;
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
        $sucursales = Sucursal::where('isActive', true)->get();
        $pagos = [
            ['id' => 1, 'name' => 'PAGADO'],
            ['id' => 2, 'name' => 'CONTRA ENTREGA'],
        ];
        $comprobantes = [
            ['id' => 1, 'name' => 'BOLETA'],
            ['id' => 2, 'name' => 'FACTURA'],
            ['id' => 3, 'name' => 'TICKET'],
        ];
        return view('livewire.package.register-live', compact('docs', 'headers_paquetes', 'sucursales', 'pagos', 'comprobantes'));
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
                    if ($this->paquetes->isNotEmpty()) {
                        $this->step++;
                        $this->toast('3 registrado correctamente.', 'success');
                    }
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
        $paquete = new Paquete();
        $paquete->cantidad = $this->cantidad;
        $paquete->description = $this->description;
        $paquete->peso = $this->peso;
        $paquete->amount = $this->amount;
        $this->paquetes->push($paquete->toArray());
    }
    public function finish()
    {
        $this->modalConfimation = true;
        //dump($this->sucursal_dest_id);
        //dump($this->pin1);
        //dump($this->pin2);
        //dump($this->doc_traslado);
        //dump($this->glosa);
        //$paquetes = $this->paquetes;
        //foreach ($paquetes as $paquete) {
        //    $this->paquetes->push(collect($paquete)->put('encomienda_id', 1));
        //}
        //dump($this->paquetes->all());
        //Paquete::upsert($this->paquetes->toArray(), null, null);
    }
}
