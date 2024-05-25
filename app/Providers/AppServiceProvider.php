<?php

namespace App\Providers;


use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Adding Aliases
        $loader = AliasLoader::getInstance();
        $loader->alias('Currency', \App\Helpers\Currency::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Event::listen('order.created', DeductProductQuantity::class);
        Event::listen('order.created', EmptyCart::class);
    }
}
