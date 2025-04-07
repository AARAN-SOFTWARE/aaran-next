<?php

namespace Aaran\BMS\Billing\Master\Providers;

use Aaran\BMS\Billing\Master\Livewire\Class\CompanyList;
use Aaran\BMS\Billing\Master\Livewire\Class\ContactList;
use Aaran\BMS\Billing\Master\Livewire\Class\ContactUpsert;
use Aaran\BMS\Billing\Master\Livewire\Class\ProductList;
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
//
//        Livewire::component('aaran.master.contact.lookup.contact-model', ContactModel::class);
//        Livewire::component('aaran.master.order.lookup.order-model', OrderModel::class);
//        Livewire::component('aaran.master.style.lookup.style-model', StyleModel::class);
//        Livewire::component('aaran.master.product.lookup.product-model', ProductModel::class);
//
//        Livewire::component('product.index', Product\Index::class);
//        Livewire::component('orders.index', Orders\Index::class);
//        Livewire::component('style.index', Style\Index::class);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }
}
