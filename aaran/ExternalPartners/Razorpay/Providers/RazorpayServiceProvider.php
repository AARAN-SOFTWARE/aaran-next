<?php

namespace Aaran\ExternalPartners\Razorpay\Providers;

use Aaran\ExternalPartners\Razorpay\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class RazorpayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RazorpayRouteProvider::class);
        $this->loadViews();
    }

    public function boot(): void
    {
        Livewire::component('razor::payment-success', Class\PaymentSuccess::class);
        Livewire::component('razor::payment-list', Class\PaymentList::class);

        $this->mergeConfigFrom(__DIR__ . '/../Config/razor.php', 'razorpay');

        $this->registerMigrations();

    }


    private function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'razorpay');
    }
}
