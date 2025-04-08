<?php

use Aaran\BMS\Billing\Master\Livewire\Class;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/companies', Class\CompanyList::class)->name('companies');

    Route::get('/contacts', Class\ContactList::class)->name('contacts');

    Route::get('/contacts/{id}/upsert', Class\ContactUpsert::class)->name('contacts.upsert');

    Route::get('/products', Class\ProductList::class)->name('products');

//
//    Route::get('/companies/{id}/upsert', Aaran\Master\Livewire\Company\Upsert::class)->name('companies.upsert');

    Route::get('/orders', Class\OrderList::class)->name('orders');

    Route::get('/styles', Class\StyleList::class)->name('styles');

});
