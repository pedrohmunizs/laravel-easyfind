<?php

namespace App\Providers;

use App\Services\CepAbertoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CepAbertoService::class, function ($app) {
            return new CepAbertoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::define('comerciante', function ($user) {
            return $user->type === 'comerciante';
        });

        Gate::define('consumidor', function ($user) {
            return $user->type === 'consumidor';
        });
    }
}
