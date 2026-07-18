<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('guests are redirected to login from admin pages', function () {
    $this->get(route('admin.users'))->assertRedirect(route('login'));
    $this->get(route('admin.roles'))->assertRedirect(route('login'));
    $this->get(route('admin.permissions'))->assertRedirect(route('login'));
});

test('non-superadmin users get 403 on admin pages', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('admin.users'))->assertForbidden();
    $this->get(route('admin.roles'))->assertForbidden();
    $this->get(route('admin.permissions'))->assertForbidden();
});

test('superadmin users can visit admin pages', function () {
    Role::firstOrCreate(['name' => 'Superadmin', 'guard_name' => 'web']);

    $user = User::factory()->create();
    $user->assignRole('Superadmin');
    $this->actingAs($user);

    $this->get(route('admin.users'))->assertOk();
    $this->get(route('admin.roles'))->assertOk();
    $this->get(route('admin.permissions'))->assertOk();
});

test('users without manage-mitras permission get 403 on mitras page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('mitras.index'))->assertForbidden();
});

test('admin with manage-mitras permission can visit mitras page', function () {
    Permission::firstOrCreate(['name' => 'manage-mitras', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web'])->givePermissionTo('manage-mitras');

    $user = User::factory()->create();
    $user->assignRole('Admin');
    $this->actingAs($user);

    $this->get(route('mitras.index'))->assertOk();
});
