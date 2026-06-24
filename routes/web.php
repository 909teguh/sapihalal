<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Mitra\Map::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('mitras', App\Livewire\Mitra\Index::class)->name('mitras.index');
});

require __DIR__.'/settings.php';
