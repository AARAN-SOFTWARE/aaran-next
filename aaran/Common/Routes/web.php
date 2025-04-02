<?php

use Illuminate\Support\Facades\Route;

//Common
Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/cities', Aaran\Common\Livewire\Class\CityList::class)->name('cities');
    Route::get('/states', Aaran\Common\Livewire\Class\StateList::class)->name('states');
    Route::get('/countries', Aaran\Common\Livewire\Class\CountryList::class)->name('countries');
    Route::get('/pin-codes', Aaran\Common\Livewire\Class\PincodeList::class)->name('pin-codes');
    Route::get('/accountType', Aaran\Common\Livewire\Class\AccountTypeList::class)->name('accountType');
    Route::get('/dispatch', Aaran\Common\Livewire\Class\DespatchList::class)->name('dispatch');
    Route::get('/gst-percents', Aaran\Common\Livewire\Class\GstPercentList::class)->name('gst-percents');
    Route::get('/hsn-codes', Aaran\Common\Livewire\Class\HsncodeList::class)->name('hsn-codes');
    Route::get('/payment-mode', Aaran\Common\Livewire\Class\PaymentModeList::class)->name('payment-mode');
    Route::get('/receipt-type', Aaran\Common\Livewire\Class\ReceiptTypeList::class)->name('receipt-type');
    Route::get('/banks', Aaran\Common\Livewire\Class\BankList::class)->name('banks');
    Route::get('/categories', Aaran\Common\Livewire\Class\CategoryList::class)->name('categories');
    Route::get('/colour', Aaran\Common\Livewire\Class\ColourList::class)->name('colours');
    Route::get('/sizes', Aaran\Common\Livewire\Class\SizeList::class)->name('sizes');
    Route::get('/contact-type', Aaran\Common\Livewire\Class\ContactTypeList::class)->name('contact-types');
    Route::get('/departments', Aaran\Common\Livewire\Class\DepartmentList::class)->name('departments');
    Route::get('/units', Aaran\Common\Livewire\Class\UnitsList::class)->name('units');
});
