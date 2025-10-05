<?php

namespace App\Providers;

use App\Adapters\Geo\GeoResolver;
use App\Adapters\Geo\IpLookStrategy;
use App\Domain\Contracts\FbiCasesContract;
use App\Adapters\Http\FbiApiClient;
use App\Domain\Contracts\GeoResolverContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FbiCasesContract::class, FbiApiClient::class);

        $this->app->bind(GeoResolverContract::class, function () {
            return new GeoResolver(
                 new IpLookStrategy(),
            );
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
