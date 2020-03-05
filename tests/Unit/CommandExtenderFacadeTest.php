<?php

namespace Wotta\CommandExtender\Tests\Unit;

use Wotta\CommandExtender\CommandExtender;
use Wotta\CommandExtender\CommandExtenderFacade;
use Wotta\CommandExtender\Tests\TestCase;

class CommandExtenderFacadeTest extends TestCase
{
    /** @test */
    public function the_command_extender_facade_returns_the_object(): void
    {
        $this->assertInstanceOf(CommandExtender::class, CommandExtenderFacade::getFacadeRoot());
    }
}
