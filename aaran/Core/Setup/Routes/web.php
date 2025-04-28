<?php

use Illuminate\Support\Facades\Route;


Route::get('/setup', Aaran\Core\Setup\Livewire\Class\TenantSetupWizard::class)->name('setup');
