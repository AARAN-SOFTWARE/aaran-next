<?php

namespace Aaran\BMS\Billing\Transaction\Providers;

use Aaran\BMS\Billing\Transaction\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TransactionServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Transaction';
    protected string $moduleNameLower = 'transaction';

    public function register(): void
    {
        $this->app->register(TransactionRouteProvider::class);
//        $this->loadConfigs();
        $this->loadViews();
    }

    public function boot(): void
    {
        Livewire::component('transaction::account-book.index', Class\AccountBook\Index::class);
        Livewire::component('transaction::account-book.lookup', Class\AccountBook\Lookup::class);


        Livewire::component('transaction::transaction.index', Class\Transaction\Index::class);


    }

//    protected function loadConfigs(): void
//    {
//        $this->mergeConfigFrom(__DIR__ . '/../config.php', $this->moduleNameLower);
//    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

    protected function loadMigrations(): void
    {

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
