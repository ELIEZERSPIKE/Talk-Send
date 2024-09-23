<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\AuthRepository;
use App\Interfaces\AuthInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class,AuthRepository::class );

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
