<?php

use Aaran\ExternalPartners\Razorpay\Http\Controllers\RazorpayController;
use Aaran\ExternalPartners\Razorpay\Livewire\Class\SubscriptionPayment;
use Illuminate\Support\Facades\Route;





Route::get('/subscription-pay', SubscriptionPayment::class)->name('subscription.pay');

Route::post('/razorpay/create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.createOrder');
Route::post('/razorpay/verify', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify');
