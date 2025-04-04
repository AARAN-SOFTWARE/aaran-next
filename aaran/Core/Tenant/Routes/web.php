<?php

use Illuminate\Support\Facades\Route;

//Common
//Route::middleware(['web'])->group(function () {
//});

Route::get('/subscriptions', \Aaran\Core\Tenant\Livewire\Class\SubscriptionList::class)->name('subscriptions');
