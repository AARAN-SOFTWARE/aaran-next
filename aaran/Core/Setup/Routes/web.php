<?php

use Illuminate\Support\Facades\Route;


Route::get('/setup', Aaran\Core\Setup\Livewire\Class\TenantSetupWizard::class)->name('setup');
Route::get('/tenant-migrations/{id}', Aaran\Core\Setup\Livewire\Class\TenantMigration::class)->name('tenant-migrations');

Route::get('/db-managers', Aaran\Core\Setup\Livewire\Class\DatabaseManager::class)->name('db-managers');
