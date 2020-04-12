<?php

namespace Wotta\IlluminateExtender\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Wotta\IlluminateExtender\IlluminateExtenderServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            IlluminateExtenderServiceProvider::class,
        ];
    }
}
