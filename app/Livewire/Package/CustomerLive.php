<?php

namespace App\Livewire\Package;

use App\Livewire\Forms\CustomerForm;
use App\Models\Package\Customer;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use App\Services\SearchService;
use App\Traits\LogCustom;

class CustomerLive extends Component
{
    use LogCustom;
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public $title = 'Clientes';
    public $sub_title = 'Modulo de clientes';
    public $search = '';
    public $perPage = 10;
    public CustomerForm $customerForm;
    public bool $modalCustomer = false; // Variable para el modal de agregar cliente
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public function render()
    {
        $customers = Customer::where(
            fn($query)
            => $query->orWhere('code', 'LIKE', '%' . $this->search . '%')
                ->orWhere('name', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%')
        )->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage, '*', 'page');
        return view('livewire.package.customer-live', compact('customers'));
    }
    public function openModal()
    {
        $this->customerForm->resetErrorBag();
        $this->customerForm->resetValidation();
        $this->customerForm->reset();
        $this->modalCustomer = !$this->modalCustomer;
    }

    public function create()
    {
        if ($this->customerForm->store()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function edit(Customer $customer)
    {
        $this->openModal();
        $this->customerForm->setCustomer($customer);
    }
    public function update()
    {
        if ($this->customerForm->update()) {
            $this->success('Genial, guardado correctamente!');
            $this->openModal();
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function estado(Customer $customer)
    {
        if ($this->customerForm->estado($customer->id)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
    public function SearchDocument()
    {
        if ($this->customerForm->code=="") {
            return 0;
        }
        $search = new SearchService();
        $document = $search->document($this->customerForm->type_code, $this->customerForm->code);
        try {

            if ($document['respuesta'] == 'ok') {
                if ($this->customerForm->type_code == 'dni') {
                    $this->customerForm->name = $document['data']->nombre;
                } else {
                    $this->customerForm->name = $document['data']->razon_social;
                    $this->customerForm->address = $document['data']->direccion;
                }
                $this->infoLog('CustomerLive SearchDocument', $this->customerForm->code);
            } else {
                $this->customerForm->reset();
            }
        } catch (\Exception $e) {
            $this->errorLog('CustomerLive SearchDocument', $e);
        }
    }
}
