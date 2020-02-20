<?php

namespace Wotta\CommandExtender\Tests;

use Orchestra\Testbench\TestCase;
use Wotta\CommandExtender\CommandExtenderServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [CommandExtenderServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
