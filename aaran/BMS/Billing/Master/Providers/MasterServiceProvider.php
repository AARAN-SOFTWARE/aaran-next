<?php

namespace Aaran\Master\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use Aaran\Master\Livewire\Company;
use Aaran\Master\Livewire\Contact;
use Aaran\Master\Livewire\Product;
use Aaran\Master\Livewire\Orders;
use Aaran\Master\Livewire\Style;

use Aaran\Master\Livewire\Contact\Lookup\ContactModel;
use Aaran\Master\Livewire\Orders\Lookup\OrderModel;
use Aaran\Master\Livewire\Style\Lookup\StyleModel;
use Aaran\Master\Livewire\Product\Lookup\ProductModel;


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
        $this->loadMigrations();

        Livewire::component('company.index', Company\Index::class);
        Livewire::component('company.upsert', Company\Upsert::class);

        Livewire::component('contact.index', Contact\Index::class);
        Livewire::component('contact.upsert', Contact\Upsert::class);


        Livewire::component('aaran.master.contact.lookup.contact-model', ContactModel::class);
        Livewire::component('aaran.master.order.lookup.order-model', OrderModel::class);
        Livewire::component('aaran.master.style.lookup.style-model', StyleModel::class);
        Livewire::component('aaran.master.product.lookup.product-model', ProductModel::class);


        Livewire::component('product.index', Product\Index::class);
        Livewire::component('orders.index', Orders\Index::class);
        Livewire::component('style.index', Style\Index::class);


    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire', $this->moduleNameLower);
    }

    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
