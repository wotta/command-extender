<?php

namespace Wotta\CommandExtender;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Wotta\CommandExtender\Skeleton\SkeletonClass
 */
class CommandExtenderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'command-extender';
    }
}
