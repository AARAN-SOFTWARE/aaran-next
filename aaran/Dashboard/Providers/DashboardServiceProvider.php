<?php

namespace Aaran\Dashboard\Providers;

use Aaran\BMS\Billing\Baseline\Livewire\Class\SwitchDefaultCompany;
use Aaran\Dashboard\Livewire\Class\SalesChart;
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
        $this->registerViews();
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);

        Livewire::component('dashboard::sales-chart', SalesChart::class);

        Livewire::component('dashboard::default-company', SwitchDefaultCompany::class);
    }
}
