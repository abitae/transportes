<?php

namespace App\Livewire\Configuration;

use App\Livewire\Forms\RoleForm;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Mary\Traits\Toast;
use Spatie\Permission\Models\Role;

class RoleLive extends Component
{
    use Toast;
    use WithPagination, WithoutUrlPagination;
    public RoleForm $roleForm;
    public $title = 'Usuarios';
    public $sub_title = 'Modulo de usuarios';
    public int $perPage = 10;
    public bool $modalRole = false;
    public function render()
    {
        $roles = Role::latest()->paginate($this->perPage);
        return view('livewire.configuration.role-live', compact('roles'));
    }
    public function openModal()
    {
        $this->roleForm->reset();
        $this->modalRole = !$this->modalRole;
    }
    public function create()
    {
        if ($this->roleForm->store()) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
    }
    public function update(Role $role)
    {
        $this->openModal();
        $this->roleForm->setRole($role);
    }
    public function edit()
    {
        if ($this->roleForm->update()) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
        $this->openModal();
    }
    public function delete(Role $role)
    {
        if ($this->roleForm->delete($role)) {
            $this->success('Genial, guardado correctamente!');
        } else {
            $this->error('Error, verifique los datos!');
        }
    }
}
