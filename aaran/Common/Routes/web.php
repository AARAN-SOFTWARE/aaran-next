<?php

use Illuminate\Support\Facades\Route;

//Common
Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/cities', Aaran\Common\Livewire\Class\CityList::class)->name('cities');
    Route::get('/states', Aaran\Common\Livewire\Class\StateList::class)->name('states');
    Route::get('/countries', Aaran\Common\Livewire\Class\CountryList::class)->name('countries');
    Route::get('/pin-codes', Aaran\Common\Livewire\Class\PincodeList::class)->name('pin-codes');
    Route::get('/accountTypes', Aaran\Common\Livewire\Class\AccountTypeList::class)->name('accountTypes');
    Route::get('/despatches', Aaran\Common\Livewire\Class\DespatchList::class)->name('despatches');
    Route::get('/gst-percents', Aaran\Common\Livewire\Class\GstPercentList::class)->name('gst-percents');
    Route::get('/hsn-codes', Aaran\Common\Livewire\Class\HsncodeList::class)->name('hsn-codes');
    Route::get('/payment-modes', Aaran\Common\Livewire\Class\PaymentModeList::class)->name('payment-modes');
    Route::get('/receipt-types', Aaran\Common\Livewire\Class\ReceiptTypeList::class)->name('receipt-types');
    Route::get('/banks', Aaran\Common\Livewire\Class\BankList::class)->name('banks');
    Route::get('/categories', Aaran\Common\Livewire\Class\CategoryList::class)->name('categories');
    Route::get('/colours', Aaran\Common\Livewire\Class\ColourList::class)->name('colours');
    Route::get('/sizes', Aaran\Common\Livewire\Class\SizeList::class)->name('sizes');
    Route::get('/contact-types', Aaran\Common\Livewire\Class\ContactTypeList::class)->name('contact-types');
    Route::get('/departments', Aaran\Common\Livewire\Class\DepartmentList::class)->name('departments');
    Route::get('/units', Aaran\Common\Livewire\Class\UnitList::class)->name('units');
});
