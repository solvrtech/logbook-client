<?php

namespace Solvrtech\LogbookClient;

use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class LogbookServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            LoggerInterface::class,
            Logbook::class
        );
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/logbook.php' => config_path('logbook.php'),
            'logbook-config'
        ]);
    }
}
