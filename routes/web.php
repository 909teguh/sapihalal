<?php

use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Mitra\Index;
use App\Livewire\Mitra\Map;
use App\Livewire\SertifikatVeteriner\Index as SertifikatVeterinerIndex;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', Map::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardIndex::class)->name('dashboard');
});

Route::middleware(['auth', 'verified', 'permission:manage-mitras'])
    ->group(function () {
        Route::get('mitras', Index::class)->name('mitras.index');
    });

Route::middleware(['auth', 'verified', 'permission:manage-sertifikat-veteriner'])
    ->group(function () {
        Route::get('sertifikat-veteriner', SertifikatVeterinerIndex::class)->name('sertifikat-veteriner.index');
    });

Route::middleware(['auth', 'verified', 'role:Superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('users', App\Livewire\Admin\Users\Index::class)->name('users');
        Route::get('roles', App\Livewire\Admin\Roles\Index::class)->name('roles');
        Route::get('permissions', App\Livewire\Admin\Permissions\Index::class)->name('permissions');
    });

require __DIR__.'/settings.php';

Route::get('/debug-role', function () {
    $user = Auth::user();

    if (! $user) {
        return 'Belum login';
    }

    return [
        'user_id' => $user->id,
        'roles' => $user->getRoleNames(),
        'permissions' => $user->getPermissionNames(),
    ];
})->middleware('auth');
