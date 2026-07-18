<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public $permissions;

    public $permissionId;

    public $permissionName;

    public function mount()
    {
        $this->loadPermissions();
    }

    public function loadPermissions()
    {
        $this->permissions = Permission::all();
    }

    public function createPermission()
    {
        $this->resetForm();
    }

    public function editPermission($id)
    {
        $permission = Permission::find($id);

        if (! $permission) {
            return;
        }

        $this->permissionId = $permission->id;
        $this->permissionName = $permission->name;
    }

    public function savePermission()
    {
        $this->validate([
            'permissionName' => 'required|string|max:255',
        ]);

        Permission::updateOrCreate(
            ['id' => $this->permissionId],
            ['name' => $this->permissionName, 'guard_name' => 'web'],
        );

        $this->loadPermissions();
        $this->resetForm();

        $this->js('document.querySelector("[data-close-permission-modal]")?.click()');
    }

    public function deletePermission($id)
    {
        Permission::destroy($id);
        $this->loadPermissions();
    }

    public function resetForm()
    {
        $this->permissionId = null;
        $this->permissionName = '';
    }

    public function render()
    {
        return view('livewire.admin.permissions.index')->layout('layouts.app');
    }
}
