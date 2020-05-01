<?php

namespace Wotta\IlluminateExtender\Console\Extended;

use Wotta\IlluminateExtender\Console\Extended\Exceptions\EnvironmentKeyDoesNotExists;

class KeyGenerateCommand extends \Illuminate\Foundation\Console\KeyGenerateCommand
{
    /**
     * @throws EnvironmentKeyDoesNotExists
     */
    public function handle()
    {
        if (! $this->checkForKey()) {
            throw new EnvironmentKeyDoesNotExists();
        }

        parent::handle();
    }

    /**
     * Check if key exist in .env.
     *
     * @return bool|int
     */
    protected function checkForKey()
    {
        return preg_match('/^\b(APP_KEY)\b/m', file_get_contents($this->laravel->environmentFilePath()));
    }
}
