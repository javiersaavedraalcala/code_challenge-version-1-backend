<?php

namespace App\Providers;

use App\Interfaces\ContactInterfaceRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ContactRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ContactInterfaceRepository::class, ContactRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
