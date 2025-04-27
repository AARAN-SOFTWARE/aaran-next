<?php

namespace Aaran\BMS\Billing\Baseline\Providers;

use Aaran\BMS\Billing\Baseline\Livewire\Class\SwitchDefaultCompany;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BaselineServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Baseline';
    protected string $moduleNameLower = 'baseline';

    public function register()
    {
        $this->app->register(BaselineRouteProvider::class);
    }

    public function boot()
    {
        $this->registerViews();
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);

        Livewire::component('Baseline::default-company', SwitchDefaultCompany::class);
    }
}
