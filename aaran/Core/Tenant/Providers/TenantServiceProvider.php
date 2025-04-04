<?php

namespace Aaran\Core\Tenant\Providers;

use Aaran\Core\Tenant\Http\Middleware\TenantMiddleware;
use Aaran\Core\Tenant\Livewire\Class\SubscriptionList;
use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class TenantServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(TenantDatabaseService::class, function ($app) {
            return new TenantDatabaseService();
        });

        $this->loadViews();
    }

    public function boot()
    {
        $this->registerMiddleware();
        $this->registerMigrations();
        $this->registerConfigs();
        $this->registerLivewire();

    }

    protected function registerLivewire(): void
    {
        Livewire::component('tenant.tenant', SubscriptionList::class);
    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', 'tenant');
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);

        // Register 'tenant' as a standalone middleware key
        $router->aliasMiddleware('tenant', TenantMiddleware::class);
    }


    private function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../Config/features.php', 'features');
    }
}


