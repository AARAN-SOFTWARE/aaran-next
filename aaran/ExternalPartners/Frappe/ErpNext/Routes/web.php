<?php

use Aaran\ExternalPartners\Frappe\ErpNext\Livewire\Class;
use Illuminate\Support\Facades\Route;
//
//Route::middleware(['auth'])->group(function () {
//    Route::get('/tenants', Class\TenantList::class)->name('tenants');
//});


Route::get('/stock-list', Class\StockList::class)->name('stock-list');
