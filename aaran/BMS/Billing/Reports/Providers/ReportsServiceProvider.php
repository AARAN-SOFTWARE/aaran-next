<?php

namespace Aaran\BMS\Billing\Reports\Providers;

use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Reports';
    protected string $moduleNameLower = 'reports';

    public function register(): void
    {
        $this->app->register(ReportsRouteProvider::class);

        $this->loadViews();
    }

    public function boot(): void
    {

//        Livewire::component('reports::contact-report', ContactReport::class);
//        Livewire::component('reports::party-report', PartyReport::class);
//
//        Livewire::component('reports::receivable', Receivable::class);
//        Livewire::component('reports::payable', Payable::class);
//        Livewire::component('reports::payables-report', PayablesReport::class);
//        Livewire::component('reports::receivables-report', ReceivablesReport::class);
//
//        Livewire::component('reports::gst-report', GstReport::class);
//        Livewire::component('reports::monthly-report', MonthlyReport::class);
//
//        Livewire::component('reports::bank', Bank::class);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire', $this->moduleNameLower);
    }

}
