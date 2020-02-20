<?php

namespace Wotta\CommandExtender;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wotta\CommandExtender\CommandExtender
 */
class CommandExtenderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CommandExtender::class;
    }
}
