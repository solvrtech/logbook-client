<?php

namespace Solvrtech\LogbookClient\Tests;

use Solvrtech\LogbookClient\LogbookServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Load package service provider.
     *
     * @param $app
     * @return string[]
     */
    protected function getApplicationProviders($app): array
    {
        return [
            LogbookServiceProvider::class,
        ];
    }
}
