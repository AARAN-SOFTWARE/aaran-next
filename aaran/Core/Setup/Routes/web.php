<?php

use Illuminate\Support\Facades\Route;

//// Web Routes
//Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
//Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

//Route::post('mfa/send', [MfaController::class, 'sendMfa'])->name('auth.mfa-send');
//Route::post('mfa/verify', [MfaController::class, 'verifyMfa'])->name('auth.mfa-verify');
//Route::post('mfa/enable', [MfaController::class, 'enableMfa'])->name('auth.mfa-enable');

//
//Route::middleware('web')->group(function () {
//    Route::get('/users', [UserController::class, 'index'])->name('users.index');
//    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//    Route::post('/users', [UserController::class, 'store'])->name('users.store');
//    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
//    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
//});

Route::get('/setup', Aaran\Core\Setup\Livewire\Class\TenantSetupWizard::class)->name('setup');
Route::get('/clients', Aaran\Core\Setup\Livewire\Class\ClientSetup::class)->name('clients');
