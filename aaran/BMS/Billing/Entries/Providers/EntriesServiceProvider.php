<?php

namespace Aaran\BMS\Billing\Entries\Providers;

use Aaran\BMS\Billing\Entries\Providers\EntriesRouteProvider;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

use Aaran\BMS\Billing\Entries\Livewire\Class;

class EntriesServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Entries';
    protected string $moduleNameLower = 'entries';

    public function register(): void
    {
        $this->app->register(EntriesRouteProvider::class);

//        $this->app->bind(SalesInvoiceController::class, function ($app) {
//            return new SalesInvoiceController();
//        });

        $this->loadViews();
    }

    public function boot(): void
    {

        Livewire::component('entries::sales-list', Class\SalesList::class);
        Livewire::component('entries::sales-upsert', Class\SalesUpsert::class);

//        Livewire::component('sales.eway-bill', Sales\EwayBill::class);
//        Livewire::component('sales.einvoice', Sales\Einvoice::class);

//        Livewire::component('purchase.index', Purchase\Index::class);
//        Livewire::component('purchase.upsert', Purchase\Upsert::class);

//        Livewire::component('payment.index', Payment\Index::class);
//
//        Livewire::component('export-sales.index', ExportSales\Index::class);
//        Livewire::component('export-sales.upsert', ExportSales\Upsert::class);
//        Livewire::component('export-sales.packing-list', ExportSales\PackingList::class);
//
    }

    protected function loadConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config.php', $this->moduleNameLower);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

}
