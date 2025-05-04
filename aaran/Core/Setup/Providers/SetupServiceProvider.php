<?php

namespace Aaran\Core\Setup\Providers;

use Aaran\Core\Setup\Console\Commands\AaranMigrateCommand;
use Aaran\Core\Setup\Console\Commands\AaranModule;
use Aaran\Core\Setup\Livewire\Class\ClientSetup;
use Aaran\Core\Setup\Livewire\Class\DatabaseManager;
use Aaran\Core\Setup\Livewire\Class\TenantMigration;
use Aaran\Core\Setup\Livewire\Class\TenantSetupWizard;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class SetupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            AaranMigrateCommand::class,
            AaranModule::class,
        ]);

        $this->app->register(SetupRouteProvider::class);
    }

    public function boot()
    {
        $this->registerViews();

        Livewire::component('setup::tenant-setup', TenantSetupWizard::class);
        Livewire::component('setup::tenant-migration', TenantMigration::class);
        Livewire::component('setup::database-manager', DatabaseManager::class);
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'setup');
    }
}
