<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified','subscribed'])->group(function () {
    Route::get('dashboard', \Aaran\Dashboard\Livewire\Class\Index::class)->name('dashboard');
});
