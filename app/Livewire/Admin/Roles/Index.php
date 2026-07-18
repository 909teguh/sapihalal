<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $roles;

    public $roleId;

    public $roleName;

    public $selectedPermissions = [];

    public $allPermissions = [];

    public function mount()
    {
        $this->loadRoles();
        $this->allPermissions = Permission::all()->toArray();
    }

    public function loadRoles()
    {
        $this->roles = Role::with('permissions')->get();
    }

    public function createRole()
    {
        $this->resetForm();
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->find($id);

        if (! $role) {
            return;
        }

        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function saveRole()
    {
        $this->validate([
            'roleName' => 'required|string|max:255',
        ]);

        $role = Role::updateOrCreate(
            ['id' => $this->roleId],
            ['name' => $this->roleName, 'guard_name' => 'web'],
        );

        $role->syncPermissions($this->selectedPermissions);

        $this->loadRoles();
        $this->resetForm();

        $this->js('document.querySelector("[data-close-role-modal]")?.click()');
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);

        if ($role && $role->name !== 'Superadmin') {
            $role->delete();
            $this->loadRoles();
        }
    }

    public function resetForm()
    {
        $this->roleId = null;
        $this->roleName = '';
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.admin.roles.index')->layout('layouts.app');
    }
}
