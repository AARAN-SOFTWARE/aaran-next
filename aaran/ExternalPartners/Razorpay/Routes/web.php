<?php

use Aaran\ExternalPartners\Razorpay\Http\Controllers\RazorpayController;
use Aaran\ExternalPartners\Razorpay\Livewire\Class;
use Illuminate\Support\Facades\Route;





Route::get('/subscription-pay', Class\SubscriptionPayment::class)->name('subscription.pay');
Route::get('/payment-success', Class\PaymentSuccess::class)->name('payment.success');
Route::get('/payment-list', Class\PaymentList::class)->name('payment.list');

Route::post('/razorpay/create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.createOrder');
Route::post('/razorpay/verify', [RazorpayController::class, 'verifyPayment'])->name('razorpay.verify');
