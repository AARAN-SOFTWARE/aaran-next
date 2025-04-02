<?php

use Illuminate\Support\Facades\Route;


//// Route for all authenticated users
//Route::middleware(['auth', 'verified'])->get('/dashboard', Index::class)->name('dashboard');


//// Route for Admin and Super Admin
//Route::middleware(['auth', 'role:admin,super-admin'])->get('/admin/dashboard', function () {
//    return 'Admin Dashboard';
//})->name('admin.dashboard');
//
//// Route for Super Admin only
//Route::middleware(['auth', 'role:super-admin'])->get('/super-admin/dashboard', function () {
//    return 'Super Admin Dashboard';
//})->name('superadmin.dashboard');

//
//Route::middleware(['auth', 'tenant'])->group(function () {
//    Route::get('dashboard', \Aaran\Dashboard\Livewire\Class\Index::class)->name('dashboard');
//});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \Aaran\Dashboard\Livewire\Class\Index::class)->name('dashboard');
});
