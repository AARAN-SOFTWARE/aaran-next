<?php

namespace Aaran\Common\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use Aaran\Common\Livewire\Class;

// Example


class CommonServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Common';
    protected string $moduleNameLower = 'common';

    public function register(): void
    {
        $this->app->register(CommonRouteProvider::class);
//        $this->loadConfigs();
        $this->loadViews();
    }

    public function boot(): void
    {
//        $this->loadMigrations();
//        $this->mapApiRoutes();
//        $this->mapWebRoutes();

        // Register Livewire components
        Livewire::component('common::city-list', Class\CityList::class);
        Livewire::component('common::hsncode-list', Class\HsncodeList::class);
        Livewire::component('common::state-list', Class\StateList::class);
        Livewire::component('common::pincode-list', Class\PincodeList::class);
        Livewire::component('common::country-list', Class\CountryList::class);
        Livewire::component('common::category-list', Class\CategoryList::class);
        Livewire::component('common::colour-list', Class\ColourList::class);
        Livewire::component('common::department-list', Class\DepartmentList::class);
        Livewire::component('common::gst-list', Class\GstList::class);
        Livewire::component('common::receipt-type-list', Class\ReceiptTypeList::class);
        Livewire::component('common::dispatch-list', Class\DispatchList::class);
        Livewire::component('common::payment-mode-list', Class\PaymentModeList::class);
        Livewire::component('common::bank-list', Class\BankList::class);
        Livewire::component('common::contact-type-list', Class\ContactTypeList::class);
        Livewire::component('common::account-type-list', Class\AccountTypeList::class);
    }

    protected function loadConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config.php', $this->moduleNameLower);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

    protected function loadMigrations(): void
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
