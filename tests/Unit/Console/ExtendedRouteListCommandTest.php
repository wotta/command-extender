<?php

namespace Wotta\CommandExtender\Tests\Unit;

use Wotta\CommandExtender\Tests\TestCase;

class ExtendedRouteListCommandTest extends TestCase
{
    /** @test */
    public function route_list_command_has_action_option(): void
    {
        $this->artisan('route:list', ['--action' => 'TestController'])
            ->assertExitCode(0);

        $this->artisan('route:list', ['--action' => 'wrongAction'])
            ->assertExitCode(0);
    }

    /** @test */
    public function route_list_command_has_open_option(): void
    {
        $this->artisan('route:list', ['--open' => null, '--editor' => 'vim'])
            ->expectsQuestion('Which file would you like to open?', 1)
            ->expectsOutput('TestController')
            ->expectsOutput('for route test_url')
            ->assertExitCode(0);
    }
}
