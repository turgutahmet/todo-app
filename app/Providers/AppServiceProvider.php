<?php

namespace App\Providers;

use App\Interfaces\TaskDistributionStrategyInterface;
use App\Services\DefaultTaskDistributionStrategy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskDistributionStrategyInterface::class, DefaultTaskDistributionStrategy::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
