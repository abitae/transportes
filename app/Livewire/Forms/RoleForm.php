<?php

namespace App\Livewire\Forms;

use App\Traits\LogCustom;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Spatie\Permission\Models\Role;

class RoleForm extends Form
{
    use LogCustom;
    public ?Role $role;

    #[Validate('required|min:4|unique:roles')]
    public $name = '';

    public function setRole(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;
    }
    public function store()
    {
        try {
            $this->validate();
            Role::create($this->all());
            $this->infoLog('Role store', $this->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role store', $e);
            return false;
        }
    }
    public function update()
    {
        try {
            $this->role->update([
                'name' => $this->name,
            ]);
            $this->infoLog('Role update', $this->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role update', $e);
            return false;
        }
    }
    public function delete($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            $this->infoLog('Role delete', $role->email);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role delete', $e);
            return false;
        }
    }
    public function permision($permisions)
    {
        try {
            $this->role->syncPermissions($permisions);
            $this->infoLog('Role permision', $this->role->name);
            return true;
        } catch (\Exception $e) {
            $this->errorLog('Role permision', $e);
            return false;
        }
    }
}
