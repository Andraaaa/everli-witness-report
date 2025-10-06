<?php

namespace App\Providers;

use App\Adapters\Geo\GeoResolver;
use App\Adapters\Geo\IpLookStrategy;
use App\Domain\Contracts\FbiCasesContract;
use App\Adapters\Http\FbiApiClient;
use App\Domain\Contracts\GeoResolverContract;
use App\Repositories\EloquentWitnessReport;
use App\Repositories\WitnessReportRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

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

        $this->app->bind(WitnessReportRepository::class, EloquentWitnessReport::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('reports', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
