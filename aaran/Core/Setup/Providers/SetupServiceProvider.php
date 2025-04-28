<?php

namespace Aaran\Core\Setup\Providers;

use Aaran\Core\Setup\Console\Commands\AaranMigrateCommand;
use Aaran\Core\Setup\Livewire\Class\ClientSetup;
use Aaran\Core\Setup\Livewire\Class\TenantSetupWizard;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class SetupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            AaranMigrateCommand::class,
        ]);

        $this->app->register(SetupRouteServiceProvider::class);
    }

    public function boot()
    {
        $this->registerViews();

        Livewire::component('setup::tenant-setup', TenantSetupWizard::class);
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'setup');
    }
}
