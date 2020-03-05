<?php

namespace Wotta\CommandExtender\Tests\Unit;

use Wotta\CommandExtender\Tests\TestCase;
use Wotta\CommandExtender\CommandExtender;

class CommandExtenderServiceProviderTest extends TestCase
{
    /** @test */
    public function can_get_the_command_extender_from_the_application(): void
    {
        $this->assertInstanceOf(CommandExtender::class, $this->app->make('command-extender'));
    }
}
