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

//
//    Route::get('/orders', Aaran\Master\Livewire\Orders\Index::class)->name('orders');
//
//    Route::get('/styles', Aaran\Master\Livewire\Style\Index::class)->name('styles');

});
