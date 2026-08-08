<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogUserLogin;

/**
 * Main Application Service Provider.
 * Bootstraps system events, listeners, and core bindings.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        /*
         * Bind custom application singletons or services here if required.
         */
    }

    /**
     * Bootstrap any application services.
     * Fulfills Requirement A by hooking the LogUserLogin event listener
     * into Laravel's native Login event.
     *
     * @return void
     */
    public function boot(): void
    {
        /*
         * Register the LogUserLogin listener to run every time
         * a user successfully logs in via Filament or native auth.
         */
        Event::listen(
            Login::class,
            LogUserLogin::class
        );
    }
}