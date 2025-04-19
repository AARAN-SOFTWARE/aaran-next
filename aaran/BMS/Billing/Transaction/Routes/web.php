<?php

use Aaran\BMS\Billing\Transaction\Livewire\Class;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('account-books', Class\AccountBook\Index::class)->name('account-books');

    Route::get('/transactions/{id}', Class\Transaction\Index::class)->name('transactions');

});
