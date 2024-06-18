<?php

namespace App\Providers;

use App\Contracts\AuthServiceInterface;
use App\Contracts\CrudServiceInterface;
use App\Contracts\WebsiteListingInterface;
use App\Services\AuthService;
use App\Services\CrudService;
use App\Services\WebsiteListingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WebsiteListingInterface::class, WebsiteListingService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(CrudServiceInterface::class, CrudService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
