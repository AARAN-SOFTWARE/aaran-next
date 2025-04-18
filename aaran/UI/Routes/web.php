<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('templates', \Aaran\UI\Livewire\Class\Index::class)->name('templates');
});
