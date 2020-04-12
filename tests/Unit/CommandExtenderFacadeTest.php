<?php

namespace Wotta\IlluminateExtender\Tests\Unit;

use Wotta\IlluminateExtender\IlluminateExtender;
use Wotta\IlluminateExtender\IlluminateExtenderFacade;
use Wotta\IlluminateExtender\Tests\TestCase;

class CommandExtenderFacadeTest extends TestCase
{
    /** @test */
    public function the_command_extender_facade_returns_the_object(): void
    {
        $this->assertInstanceOf(IlluminateExtender::class, IlluminateExtenderFacade::getFacadeRoot());
    }
}
