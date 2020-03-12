<?php

namespace Wotta\CommandExtender\Console;

use Illuminate\Routing\Console\ControllerMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends ControllerMakeCommand
{
    protected function getStub(): string
    {
        // Check if we have our own stuff that we need to handle.
        return parent::getStub();
    }

    protected function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            ['mixed', null, InputOption::VALUE_NONE, 'Create a api controller and a web controller'],
        ]);
    }
}
