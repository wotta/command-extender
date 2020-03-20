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
            while (! $this->option('model')) {
                $this->error('We need an model');
                $this->input->setOption('model', $this->ask('What\'s the model?'));
            }

            $originalName = $this->argument('name');
            $originalOutput = $this->getOutput();

            $this->info(
                sprintf(
                    'Generating %s%s.',
                    $name = $this->argument('name'),
                    Str::contains($name, 'Controller') ? '\'s' : ' controllers'
                )
            );

            $this->call(
                'make:controller',
                [
                    'name' => 'Api/'.$this->argument('name'),
                    '--model' => $this->option('model'),
                    '--mixed-api' => true,
                    '--force' => $this->option('force'),
                ]
            );

            $this->setOutput($originalOutput);

            $this->call(
                'make:controller',
                [
                    'name' => $originalName,
                    '--model' => $this->option('model'),
                    '--mixed-web' => true,
                    '--force' => $this->option('force'),
                ]
            );

            $this->setOutput($originalOutput);

            return true;
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
}
