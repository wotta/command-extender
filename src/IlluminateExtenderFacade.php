<?php

namespace Wotta\IlluminateExtender;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wotta\IlluminateExtender\IlluminateExtender
 */
class IlluminateExtenderFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IlluminateExtender::class;
    }
}
