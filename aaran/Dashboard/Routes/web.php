<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \Aaran\Dashboard\Livewire\Class\Index::class)->name('dashboard');
    Route::get('switch-default-company', \Aaran\Dashboard\Livewire\Class\SwitchDefaultCompany::class)->name('switch-default-company');
});
