<?php

namespace App\Providers;

use \App\Domain\Contracts\FbiCasesContract;
use App\Adapters\Http\FbiApiClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FbiCasesContract::class, FbiApiClient::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
