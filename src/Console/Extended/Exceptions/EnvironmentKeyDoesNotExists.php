<?php

namespace Wotta\IlluminateExtender\Console\Extended\Exceptions;

use Exception;
use Throwable;

class EnvironmentKeyDoesNotExists extends Exception
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct(
            'Key "APP_KEY" does not exist in file ".env". Please add it.',
            $code,
            $previous
        );
    }
}
