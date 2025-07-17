<?php

namespace App\Providers;

use App\Repositories\Eloquent\SupplierRepository;
use App\Repositories\SupplierRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
    }
}
