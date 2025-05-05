<?php

namespace Aaran\ExternalPartners\MasterGst\Providers;

use Aaran\ExternalPartners\MasterGst\Livewire\Class\Authenticate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class MasterGstServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(MasterGstRouteProvider::class);
    }

    public function boot()
    {
        $this->registerViews();
        $this->registerMigrations();
        $this->getConfig();

         Livewire::component('mastergst::authenticate', Authenticate::class);
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'mastergst');
    }

    private function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function getConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/services.php', 'mastergst');
    }
}
