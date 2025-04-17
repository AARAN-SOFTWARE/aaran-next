<?php

namespace Aaran\Blog\Providers;

use Aaran\Blog\Livewire\Class;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class BlogServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Blog';
    protected string $moduleNameLower = 'blog';

    public function register(): void
    {
        $this->app->register(BlogRouteProvider::class);
        $this->loadViews();
    }

    public function boot(): void
    {
        // Register Livewire components
        Livewire::component('blog::index', Class\Index::class);
        Livewire::component('blog::category', Class\Category::class);
        Livewire::component('blog::blog-tag', Class\Tag::class);
        Livewire::component('blog::blog-show', Class\Show::class);

    }

    protected function loadViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../Livewire/Views', $this->moduleNameLower);
    }

}
