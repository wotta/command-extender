<?php

namespace Wotta\IlluminateExtender\Tests\Unit;

use Wotta\IlluminateExtender\IlluminateExtender;
use Wotta\IlluminateExtender\Tests\TestCase;

class CommandExtenderServiceProviderTest extends TestCase
{
    /** @test */
    public function can_get_the_command_extender_from_the_application(): void
    {
        $this->assertInstanceOf(IlluminateExtender::class, $this->app->make('command-extender'));
    }
}
