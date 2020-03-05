<?php

namespace Wotta\CommandExtender\Tests\Unit;

use Wotta\CommandExtender\Tests\TestCase;

class ExtendedRouteListCommandTest extends TestCase
{
    /** @test */
    public function route_list_command_has_action_option()
    {
        $this->artisan('route:list', ['--action' => 'TestController'])
            ->assertExitCode(0);

        $this->artisan('route:list', ['--action' => 'wrongAction'])
            ->assertExitCode(0);
    }
}
