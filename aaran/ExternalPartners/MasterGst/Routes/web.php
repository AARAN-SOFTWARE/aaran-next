<?php
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::get('/gstAuth', Aaran\ExternalPartners\MasterGst\Livewire\Class\Authenticate::class)->name('gstAuth');

});
