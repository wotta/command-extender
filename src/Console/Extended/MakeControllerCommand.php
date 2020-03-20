<?php

namespace Wotta\CommandExtender\Console\Extended;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Console\ControllerMakeCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends ControllerMakeCommand
{
    /**
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        if ($this->option('mixed')) {
            return $this->generateMixedControllers();
        }

        return parent::handle();
    }

    protected function getStub(): string
    {
        $stub = parent::getStub();

        if ($this->option('mixed-web')) {
            $stub = __DIR__.'/../stubs/controller.mixed.stub';
        }

        if ($this->option('mixed-api')) {
            $stub = __DIR__.'/../stubs/controller.api.mixed.stub';
        }

        return $stub;
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['mixed', null, InputOption::VALUE_NONE, 'Create a api controller and a web controller'],
            ['mixed-web', null, InputOption::VALUE_NONE, 'Create a web controller for the mixed option'],
            ['mixed-api', null, InputOption::VALUE_NONE, 'Create a api controller for the mixed option'],
        ]);
    }

    private function generateMixedControllers(): bool
    {
        $this->askModel();

        $originalName = $this->argument('name');
        $originalOutput = $this->getOutput();

        $attributes = $this->getCommandAttributes();

        $this->displayInformationTest();

        $this->callCommand('make:controller', $attributes, function () use ($originalOutput) {
            $this->setOutput($originalOutput);
        });

        $attributes['name'] = $originalName;
        $attributes['--mixed-web'] = true;

        unset($attributes['--mixed-api']);

        $this->callCommand('make:controller', $attributes);

        $this->setOutput($originalOutput);

        return true;
    }

    private function askModel(): void
    {
        while (! $this->option('model')) {
            $this->error('We need an model');
            $this->input->setOption('model', $this->ask('What\'s the model?'));
        }
    }

    private function displayInformationTest(): void
    {
        $this->info(
            sprintf(
                'Generating %s%s.',
                $name = $this->argument('name'),
                Str::contains($name, 'Controller') ? '\'s' : ' controllers'
            )
        );
    }

    private function getCommandAttributes(): array
    {
        return [
            'name' => 'Api/'.$this->argument('name'),
            '--model' => $this->option('model'),
            '--mixed-api' => true,
            '--force' => $this->option('force'),
        ];
    }

    private function callCommand(string $command, array $attributes = [], callable $callback = null): void
    {
        $this->call(
            $command,
            $attributes
        );

        if ($callback) {
            call_user_func($callback);
        }
    }
}
