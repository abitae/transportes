<?php

namespace App\Livewire\Forms;

use App\Models\Package\Customer;
use App\Traits\LogCustom;
use App\Traits\SearchDocument;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    use LogCustom, SearchDocument;

    public ?Customer $customer;
    public $customer_id;

    #[Validate('required')]
    public $type_code = 'dni';
    #[Validate('required|numeric|digits_between:8,11')]
    public $code = '';
    #[Validate('required')]
    public $name = '';
    #[Validate('')]
    public $phone = '';
    #[Validate('email')]
    public $email = '';
    #[Validate('')]
    public $address = '';
    public $isActive = true;

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        $this->type_code = $customer->type_code;
        $this->code = $customer->code;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
        $this->address = $customer->address;
    }

    public function store()
    {
        try {
            $data = $this->search($this->type_code, $this->code);
            if ($data['encontrado']) {
                $this->populateCustomerData($data['data']);
                $customer = Customer::firstOrCreate(
                    ['type_code' => $this->type_code, 'code' => $this->code],
                    ['name' => $this->name, 'phone' => $this->phone, 'email' => $this->email, 'address' => $this->address]
                );
                $this->updateCustomerFields($customer);
                $this->infoLog('Customer store ' . $this->code);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $this->errorLog('Customer store', $e);
            return false;
        }
    }

    public function update()
    {
        try {
            $this->validate();
            $customer = Customer::updateOrCreate(
                ['type_code' => $this->type_code, 'code' => $this->code],
                ['name' => $this->name, 'phone' => $this->phone, 'email' => $this->email, 'address' => $this->address]
            );
            $this->infoLog('Customer update ' . $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer update', $e);
            return false;
        }
    }

    public function destroy($id)
    {
        return $this->performAction($id, function ($customer) {
            $customer->delete();
        }, 'Customer destroy');
    }

    public function estado($id)
    {
        return $this->performAction($id, function ($customer) {
            $customer->isActive = !$customer->isActive;
            $customer->save();
        }, 'Customer estado');
    }

    private function populateCustomerData($data)
    {
        if ($this->type_code == 'dni') {
            $this->name = $data->nombre;
        } elseif ($this->type_code == 'ruc') {
            $this->name = $data->razon_social;
            $this->address = $data->direccion;
        }
    }

    private function updateCustomerFields(Customer $customer)
    {
        $this->phone = $customer->phone;
        $this->email = $customer->email;
        $this->address = $customer->address;
        $this->customer_id = $customer->id;
    }

    private function performAction($id, callable $action, $logMessage)
    {
        try {
            $customer = Customer::find($id);
            $action($customer);
            $this->infoLog($logMessage . ' ' . $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog($logMessage, $e);
            return false;
        }
    }
}
