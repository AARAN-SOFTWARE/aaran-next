<?php

namespace Aaran\Neot\Providers;

use Aaran\BMS\Billing\Baseline\Livewire\Class\SwitchDefaultCompany;
use Aaran\Neot\Livewire\Class\Chatbot;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class NeotServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Neot';
    protected string $moduleNameLower = 'neot';

    public function register()
    {
        $this->app->register(NeotRouteProvider::class);
    }

    public function boot()
    {
        $this->registerViews();
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Partials', 'neot.partials');

        Livewire::component('neot::chatbot', Chatbot::class);
    }
}
