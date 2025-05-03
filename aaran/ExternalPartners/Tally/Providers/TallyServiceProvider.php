<?php

namespace Aaran\ExternalPartners\Tally\Providers;

use Aaran\ExternalPartners\Tally\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TallyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(TallyRouteProvider::class);
        $this->loadViews();
    }

    public function boot(): void
    {
        Livewire::component('tally::Tally-handshake', Class\TallyHandshake::class);

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'tally');
    }
}
