<?php
namespace App\Providers;

use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Event::listen(
            Registered::class,
            [SendEmailVerificationNotification::class, 'handle']
        );

        Event::listen(
            Registered::class,
            [SendWelcomeNotification::class, 'handle']
        );
    }
}
