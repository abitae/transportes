<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Traits\LogCustom;
use App\Models\Package\Customer;

class CustomerForm extends Form
{
    use LogCustom;
    public ?Customer $customer;
    #[Validate('required')]
    public $type_code='dni';
    #[Validate('required|numeric|digits_between:8,11|unique:customers')]
    public $code = '';
    #[Validate('required')]
    public $name = '';
    #[Validate('')]
    public $phone = '';
    #[Validate('email')]
    public $email = '';
    #[Validate('')]
    public $address = '';
    public $isActive = false;
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
        $this->validate();

        try {
            Customer::create([
                'type_code' => $this->type_code,
                'code' => $this->code,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
            ]);
            $this->infoLog('Role store', $this->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->customer->update([
                'type_code' => $this->type_code,
                'code' => $this->code,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
            ]);
            $this->infoLog('Customer update', $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer update', $e);
            return false;
        }
    }
    public function destroy($id)
    {
        try {
            $customer = Customer::find($id);
            $customer->delete();
            $this->infoLog('Customer update', $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer update', $e);
            return false;
        }
    }
    public function estado($id)
    {
        try {
            $customer = Customer::find($id);
            $customer->isActive = !$customer->isActive;
            $customer->save();
            $this->infoLog('Customer update', $this->code);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Customer update', $e);
            return false;
        }
    }
}
