<?php

namespace Aaran\Website\Providers;

use Aaran\Website\Http\Middleware\WebsiteMiddleware;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class WebsiteServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Website';
    protected string $moduleNameLower = 'website';

    public function register()
    {
        $this->app->register(WebsiteRouteProvider::class);
    }

    public function boot()
    {
        $this->registerMiddleware();
//        $this->registerConfigs();
        $this->registerMigrations();
        $this->registerViews();
    }


    protected function registerMiddleware()
    {
        $router = $this->app->make(Router::class);

        // Register 'tenant' as a standalone middleware key
        $router->aliasMiddleware('website', WebsiteMiddleware::class);
    }

    private function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    private function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

}
