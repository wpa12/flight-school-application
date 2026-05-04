<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RegistrationService;
use App\Repositories\UserRepository;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bindIf(RegistrationService::class, function ($app) {
            return new RegistrationService($app->make(UserRepository::class)); // bind the UserService with UserRepository
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
