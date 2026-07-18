<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('guests are redirected to login from sertifikat veteriner page', function () {
    $this->get(route('sertifikat-veteriner.index'))->assertRedirect(route('login'));
});

test('users without permission get 403 on sertifikat veteriner page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('sertifikat-veteriner.index'))->assertForbidden();
});

test('admin with manage-sertifikat-veteriner permission can visit page', function () {
    Permission::firstOrCreate(['name' => 'manage-sertifikat-veteriner', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web'])->givePermissionTo('manage-sertifikat-veteriner');

    $user = User::factory()->create();
    $user->assignRole('Admin');
    $this->actingAs($user);

    $this->get(route('sertifikat-veteriner.index'))->assertOk();
});
