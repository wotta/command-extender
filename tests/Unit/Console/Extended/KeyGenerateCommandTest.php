<?php

namespace Wotta\IlluminateExtender\Tests\Unit\Console\Extended;

use Illuminate\Support\Facades\File;
use Wotta\IlluminateExtender\Console\Extended\Exceptions\EnvironmentKeyDoesNotExists;
use Wotta\IlluminateExtender\Tests\TestCase;

class KeyGenerateCommandTest extends TestCase
{
    protected function tearDown(): void
    {
        File::delete($this->app->environmentFilePath());

        parent::tearDown();
    }

    /** @test */
    public function it_can_generate_an_application_key(): void
    {
        File::copy(__DIR__.'/../../../Fixtures/environment/.env.complete', $this->app->environmentFilePath());

        $this->artisan('key:generate');

        $this->refreshApplication();

        $this->assertIsString(env('APP_KEY'));

        File::delete($this->app->environmentFilePath());
    }

    /** @test */
    public function it_throws_an_exception_when_the_app_key_is_missing(): void
    {
        $this->expectExceptionMessage('Key "APP_KEY" does not exist in file ".env". Please add it.');
        $this->expectException(EnvironmentKeyDoesNotExists::class);

        File::copy(__DIR__.'/../../../Fixtures/environment/.env.missing', $this->app->environmentFilePath());

        $this->artisan('key:generate');

        $this->refreshApplication();

        File::delete($this->app->environmentFilePath());
    }
}
