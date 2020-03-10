<?php

namespace Wotta\CommandExtender\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Wotta\CommandExtender\CommandExtenderServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            CommandExtenderServiceProvider::class,
        ];
    }
}
