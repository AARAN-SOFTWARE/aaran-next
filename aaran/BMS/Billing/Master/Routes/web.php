<?php

use Illuminate\Support\Facades\Route;

//Master
Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/companies', \Aaran\BMS\Billing\Master\Livewire\Class\CompanyList::class)->name('companies');

//    Route::get('/companies/{id}/upsert', Aaran\Master\Livewire\Company\Upsert::class)->name('companies.upsert');
//
//    Route::get('/contacts', Aaran\Master\Livewire\Contact\Index::class)->name('contacts');
//    Route::get('/contacts/{id}/upsert', Aaran\Master\Livewire\Contact\Upsert::class)->name('contacts.upsert');
//
//    Route::get('/products', Aaran\Master\Livewire\Product\Index::class)->name('products');
//
//    Route::get('/orders', Aaran\Master\Livewire\Orders\Index::class)->name('orders');
//
//    Route::get('/styles', Aaran\Master\Livewire\Style\Index::class)->name('styles');


});
