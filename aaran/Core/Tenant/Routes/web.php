<?php

use Aaran\Core\Tenant\Livewire\Class;
use Illuminate\Support\Facades\Route;


Route::get('/subscriptions', Class\SubscriptionList::class)->name('subscriptions');
Route::get('/tenants', Class\TenantList::class)->name('tenants');
