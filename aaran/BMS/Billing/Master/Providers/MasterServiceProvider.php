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
        Livewire::component('master::company.index', Class\Company\Index::class);

        Livewire::component('master::contact.index', Class\Contact\Index::class);
        Livewire::component('master::contact.modal', Class\Contact\Modal::class);
        Livewire::component('master::contact.lookup', Class\Contact\Lookup::class);
        Livewire::component('master::contact.billing-address', Class\Contact\BillingAddress::class);
        Livewire::component('master::contact.shipping-address', Class\Contact\ShippingAddress::class);
        Livewire::component('master::contact.address-modal', Class\Contact\AddressModal::class);

        Livewire::component('master::product.index', Class\Product\Index::class);
        Livewire::component('master::product.modal', Class\Product\Modal::class);
        Livewire::component('master::product.lookup', Class\Product\Lookup::class);


        Livewire::component('master::order.index', Class\Order\Index::class);
        Livewire::component('master::order.modal', Class\Order\Modal::class);
        Livewire::component('master::order.lookup', Class\Order\Lookup::class);

        Livewire::component('master::style.index', Class\Style\Index::class);
        Livewire::component('master::style.modal', Class\Style\Modal::class);
        Livewire::component('master::style.lookup', Class\Style\Lookup::class);

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }
}
