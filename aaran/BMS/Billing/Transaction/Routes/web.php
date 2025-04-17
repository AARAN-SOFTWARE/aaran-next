<?php

use Aaran\BMS\Billing\Transaction\Livewire\Class;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('account-books', Class\AccountBook\Index::class)->name('account-books');

    //    Route::get('trans/{id?}', Aaran\Transaction\Livewire\AccountBook\Trans::class)->name('trans');
//
//    Route::get('trans/{id}/print', Aaran\Transaction\Controllers\Transaction\TransController::class)->name('trans.print');
//    Route::get('bankBooks/{id?}', Aaran\Transaction\Livewire\AccountBook\Index::class)->name('bankBooks');
//    Route::get('cashBooks/{id?}', Aaran\Transaction\Livewire\AccountBook\Index::class)->name('cashBooks');
//    Route::get('UPI/{id?}', Aaran\Transaction\Livewire\AccountBook\Index::class)->name('UPI');
//
//    Route::get('reports/{id?}', Aaran\Reports\Livewire\Transaction\Bank::class)->name('reports');
//    Route::get('cashReports/{id?}', Aaran\Reports\Livewire\Transaction\Bank::class)->name('cashReports');
//    Route::get('report/print/{party}/{start_date?}/{end_date?}', Aaran\Transaction\Controllers\Transaction\BookReportController::class)->name('report.print');

});
