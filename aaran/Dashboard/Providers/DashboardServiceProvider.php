<?php

namespace Aaran\Dashboard\Providers;

use Aaran\Dashboard\Livewire\Class\SalesChart;
use Aaran\Dashboard\Livewire\Class\SwitchDefaultCompany;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class DashboardServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Dashboard';
    protected string $moduleNameLower = 'dashboard';

    public function register()
    {
        $this->app->register(DashboardRouteProvider::class);
    }

    public function boot()
    {
//        $this->registerConfigs();
//        $this->registerRoutes();
//        $this->registerMigrations();
        $this->registerViews();
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/dashboard.php',  $this->moduleNameLower);
    }

    private function registerRoutes()
    {


//        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
//        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);

        Livewire::component('dashboard::sales-chart', SalesChart::class);
        Livewire::component('dashboard::default-company', SwitchDefaultCompany::class);
    }

}
