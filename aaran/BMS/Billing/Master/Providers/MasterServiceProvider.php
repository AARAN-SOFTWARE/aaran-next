<?php

namespace Aaran\BMS\Billing\Master\Providers;

use Aaran\BMS\Billing\Master\Livewire\Class\CompanyList;
use Aaran\BMS\Billing\Master\Livewire\Class\ContactList;
use Aaran\BMS\Billing\Master\Livewire\Class\ContactUpsert;
use Aaran\BMS\Billing\Master\Livewire\Class\OrderList;
use Aaran\BMS\Billing\Master\Livewire\Class\ProductList;
use Aaran\BMS\Billing\Master\Livewire\Class\StyleList;
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
        Livewire::component('master::company-list', CompanyList::class);
        Livewire::component('master::contact-list', ContactList::class);
        Livewire::component('master::contact.upsert', ContactUpsert::class);
        Livewire::component('master::product-list', ProductList::class);
        Livewire::component('master::order-list', OrderList::class);
        Livewire::component('master::style-list', StyleList::class);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }
}
