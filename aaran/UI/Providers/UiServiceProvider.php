<?php

namespace Aaran\UI\Providers;

use Illuminate\Support\ServiceProvider;

class UiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(UiRouteProvider::class);
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources', 'Ui'); // Important: Load views from module

        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'templates');

    }
}
