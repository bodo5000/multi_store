<?php

namespace App\Providers;


use App\Events\OrderCreated;
use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use App\Listeners\SendOrderCreatedNotification;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use App\Policies\RolePolicy;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
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

        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Event::listen(OrderCreated::class, EmptyCart::class);
        JsonResource::withoutWrapping();

        Gate::before(function (Admin $admin) {
            if ($admin->super_admin) {
                return true;
            }
        });

        foreach ($this->app->make('abilities') as $code => $label) {
            Gate::define($code, function (User|Admin $user) use ($code) {
                return $user->hasAbility($code);
            });

        }
        // App::setLocale(request('locale', 'en'));

        // Event::listen('order.created', DeductProductQuantity::class);
        // Event::listen('order.created', EmptyCart::class);
        // Event::listen(OrderCreated::class, DeductProductQuantity::class);
        // Event::listen(OrderCreated::class, SendOrderCreatedNotification::class);
    }
}
