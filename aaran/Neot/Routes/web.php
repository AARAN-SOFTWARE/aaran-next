<?php

use Aaran\Neot\Http\Controllers\WhatsAppWebhookController;
use Aaran\Neot\Livewire\Class;
use Illuminate\Support\Facades\Route;

//Route::middleware(['auth', 'verified'])->group(function () {
//    Route::get('switch-default-company', \Aaran\BMS\Billing\Baseline\Livewire\Class\SwitchDefaultCompany::class)->name('switch-default-company');

//});


Route::get('/chatbots', Class\Chatbot::class)->name('chatbots');

Route::post('/whatsapp/webhook', [WhatsAppWebhookController::class, 'receive']);
Route::get('/chat', Class\WhatsAppChat::class);
