<?php

namespace Aaran;

use Aaran\Common\Providers\CommonServiceProvider;
use Aaran\Core\Setup\Providers\SetupServiceProvider;
use Aaran\Core\Tenant\Providers\TenantServiceProvider;
use Aaran\Core\User\Providers\UserServiceProvider;
use Aaran\Dashboard\Providers\DashboardServiceProvider;
use Aaran\UI\Providers\UiServiceProvider;
use Aaran\Website\Providers\WebsiteServiceProvider;
use Illuminate\Support\ServiceProvider;

class AaranServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(TenantServiceProvider::class);

        $this->app->register(UiServiceProvider::class);

        $this->app->register(SetupServiceProvider::class);

        $this->app->register(UserServiceProvider::class);

        $this->app->register(WebsiteServiceProvider::class);

        $this->app->register(DashboardServiceProvider::class);

        $this->app->register(CommonServiceProvider::class);
    }

    public function boot()
    {
        //
    }
}
