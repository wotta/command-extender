<?php

namespace Wotta\CommandExtender\Tests\Unit\Console\Extended;

use Illuminate\Support\Facades\File;
use Wotta\CommandExtender\Tests\TestCase;

class MakeControllerCommandTest extends TestCase
{
    /** @test */
    public function command_can_make_mixed_controllers()
    {
        $this->artisan('make:controller', ['name' => 'TestController', '--mixed' => true])
            ->expectsQuestion('What\'s the model?', 'null')
            ->expectsQuestion('A App\null model does not exist. Do you want to generate it?', false)
            ->expectsQuestion('A App\null model does not exist. Do you want to generate it?', false);

        $this->assertFileExists($this->getBasePath().'/app/Http/Controllers/TestController.php');
        $this->assertFileExists($this->getBasePath().'/app/Http/Controllers/Api/TestController.php');
    }

    /** @test */
    public function command_asks_to_generate_model_twice_and_generates_it(): void
    {
        $this->artisan('make:controller', ['name' => 'TestController', '--mixed' => true])
            ->expectsQuestion('What\'s the model?', 'null')
            ->expectsQuestion('A App\null model does not exist. Do you want to generate it?', true)
            ->expectsQuestion('A App\null model does not exist. Do you want to generate it?', false);

        $this->assertFileExists($this->getBasePath().'/app/null.php');
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->getBasePath().'/app/Http');
        File::delete($this->getBasePath().'/app/null.php');

        parent::tearDown();
    }
}
