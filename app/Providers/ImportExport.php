<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImportExport extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ImportExport::class, function ($app) {
            return new ImportExport($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function test()
    {
        return 'TEST';
    }
}
