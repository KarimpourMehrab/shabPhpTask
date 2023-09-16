<?php

namespace App\Providers;

use App\Services\Search\SearchServiceResolver;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('searchService', function () {
            return new SearchServiceResolver();
        });
    }
}
