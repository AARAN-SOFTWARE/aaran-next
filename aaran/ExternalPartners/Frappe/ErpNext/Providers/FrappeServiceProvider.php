<?php

namespace Aaran\ExternalPartners\Frappe\ErpNext\Providers;

use Aaran\ExternalPartners\Frappe\ErpNext\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class FrappeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(FrappeRouteProvider::class);
        $this->loadViews();
    }

    public function boot(): void
    {
        Livewire::component('frappe::stock-list', Class\StockList::class);

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'frappe');
    }
}
