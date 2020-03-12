<?php

namespace Wotta\CommandExtender\Console\Extended;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends ControllerMakeCommand
{
    protected function getStub(): string
    {
        $stub = parent::getStub();

        if ($this->option('mixed')) {
            $stub = __DIR__.'/stubs/controller.mixed.stub';
        }

        return $stub;
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['mixed', null, InputOption::VALUE_NONE, 'Create a api controller and a web controller'],
        ]);
    }
}
