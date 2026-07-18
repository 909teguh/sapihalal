<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $users;

    public $userId;

    public $userName;

    public $userEmail;

    public $selectedRoles = [];

    public $allRoles = [];

    public function mount()
    {
        $this->loadUsers();
        $this->allRoles = Role::all()->toArray();
    }

    public function loadUsers()
    {
        $this->users = User::with('roles')->get();
    }

    public function editUserRoles($id)
    {
        $user = User::with('roles')->find($id);

        if (! $user) {
            return;
        }

        $this->userId = $user->id;
        $this->userName = $user->name;
        $this->userEmail = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
    }

    public function saveUserRoles()
    {
        $user = User::find($this->userId);

        if (! $user) {
            return;
        }

        $user->syncRoles($this->selectedRoles);

        $this->loadUsers();
        $this->resetForm();

        $this->js('document.querySelector("[data-close-user-modal]")?.click()');
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->userName = '';
        $this->userEmail = '';
        $this->selectedRoles = [];
    }

    public function render()
    {
        return view('livewire.admin.users.index')->layout('layouts.app');
    }
}
