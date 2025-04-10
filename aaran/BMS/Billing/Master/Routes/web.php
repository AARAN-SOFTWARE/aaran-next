<?php

use Aaran\BMS\Billing\Master\Livewire\Class;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/companies', Class\Company\Index::class)->name('companies');

    Route::get('/contacts', Class\Contact\Index::class)->name('contacts');

    Route::get('/contacts/{id}/upsert', Class\Contact\Upsert::class)->name('contacts.upsert');

    Route::get('/products', Class\Product\Index::class)->name('products');

//
//    Route::get('/companies/{id}/upsert', Aaran\Master\Livewire\Company\Upsert::class)->name('companies.upsert');

    Route::get('/orders', Class\Order\Index::class)->name('orders');

    Route::get('/styles', Class\Style\Index::class)->name('styles');

});
