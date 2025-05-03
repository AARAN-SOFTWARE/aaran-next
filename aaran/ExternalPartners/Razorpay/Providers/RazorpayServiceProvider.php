<?php

namespace Aaran\ExternalPartners\Razorpay\Providers;

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
//        Livewire::component('tally::Tally-handshake', Class\TallyHandshake::class);

        $this->mergeConfigFrom(__DIR__ . '/../Config/razor.php', 'razorpay');

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'razorpay');
    }
}
