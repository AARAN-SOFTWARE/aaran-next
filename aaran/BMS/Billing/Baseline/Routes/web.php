<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('switch-default-company', \Aaran\BMS\Billing\Baseline\Livewire\Class\SwitchDefaultCompany::class)->name('switch-default-company');

});
