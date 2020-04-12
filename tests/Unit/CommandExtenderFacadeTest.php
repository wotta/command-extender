<?php

namespace Wotta\CommandExtender\Tests\Unit;

use Wotta\CommandExtender\IlluminateExtender;
use Wotta\CommandExtender\IlluminateExtenderFacade;
use Wotta\CommandExtender\Tests\TestCase;

class CommandExtenderFacadeTest extends TestCase
{
    /** @test */
    public function the_command_extender_facade_returns_the_object(): void
    {
        $this->assertInstanceOf(IlluminateExtender::class, IlluminateExtenderFacade::getFacadeRoot());
    }
}
