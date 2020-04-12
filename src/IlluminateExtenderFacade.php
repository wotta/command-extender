<?php

namespace Wotta\CommandExtender;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wotta\CommandExtender\IlluminateExtender
 */
class IlluminateExtenderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IlluminateExtender::class;
    }
}
