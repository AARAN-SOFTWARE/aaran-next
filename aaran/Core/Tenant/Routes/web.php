<?php

use Aaran\Core\Tenant\Livewire\Class;
use Illuminate\Support\Facades\Route;


Route::get('/tenants', Class\TenantList::class)->name('tenants');
Route::get('/plan-lists', Class\PlanList::class)->name('plan-lists');
Route::get('/feature-lists', Class\FeatureList::class)->name('feature-lists');
Route::get('/plan-feature-lists', Class\PlanFeatureList::class)->name('plan-feature-lists');
Route::get('/subscriptions', Class\SubscriptionList::class)->name('subscriptions');


Route::get('/subscription-expired', Class\SubscriptionList::class)->name('subscription.expired');

Route::get('/subscription-expired', function () {
    return view('tenant.blade::subscription-expired'); // Create a blade file
})->name('subscription.expired');

Route::get('/subscription-renew', function () {
    return view('tenant.blade::subscription-renew'); // Create a blade file
})->name('subscription.renew');

//
//Route::get('/subscription-pay', function () {
//    return view('tenant.blade::subscription-pay'); // Create a blade file
//})->name('subscription.pay');
