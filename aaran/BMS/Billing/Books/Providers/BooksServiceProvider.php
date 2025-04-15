<?php

namespace Aaran\BMS\Billing\Books\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Aaran\BMS\Billing\Books\Livewire\Class;

class BooksServiceProvider extends ServiceProvider
{
    protected string $moduleNameLower = 'books';

    public function register(): void
    {
        $this->app->register(BooksRouteProvider::class);

        $this->loadViews();
    }

    public function boot(): void
    {
        // Register Livewire components
        Livewire::component('books::account-head', Class\AccountHeadList::class);
        Livewire::component('books::ledger-group', Class\LedgerGroupList::class);
        Livewire::component('books::ledger', Class\LedgerList::class);

        Livewire::component('books::lookup.ledger', Class\Lookup\LedgerLookup::class);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }
}
