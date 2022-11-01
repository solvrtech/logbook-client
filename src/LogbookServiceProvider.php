<?php

namespace Solvrtech\LogbookClient;

use Illuminate\Support\ServiceProvider;

class LogbookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/logbook.php' => config_path('logbook.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(
            'Solvrtech\LogbookClient\Logbook');
    }
}