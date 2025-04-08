<?php

namespace Aaran\BMS\Billing\Master\Providers;

use Aaran\BMS\Billing\Master\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class MasterServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Master';
    protected string $moduleNameLower = 'master';

    public function register(): void
    {
        $this->app->register(MasterRouteProvider::class);

        $this->loadViews();
    }

    public function boot(): void
    {
        Livewire::component('master::company-list', Class\CompanyList::class);
        Livewire::component('master::contact-list', Class\ContactList::class);
        Livewire::component('master::contact.upsert', Class\ContactUpsert::class);
        Livewire::component('master::product-list', Class\ProductList::class);
        Livewire::component('master::order-list', Class\OrderList::class);
        Livewire::component('master::style-list', Class\StyleList::class);

        Livewire::component('master::contact-modal', Class\ContactModal::class);

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }
}
