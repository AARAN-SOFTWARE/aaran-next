<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('accountHeads', Aaran\BMS\Billing\Books\Livewire\Class\AccountHeadList::class)->name('accountHeads');

    Route::get('ledgerGroups', Aaran\BMS\Billing\Books\Livewire\Class\LedgerGroupList::class)->name('ledgerGroups');

    Route::get('ledgers', Aaran\BMS\Billing\Books\Livewire\Class\LedgerList::class)->name('ledgers');
});
