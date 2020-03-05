<?php

namespace Wotta\CommandExtender;

use Illuminate\Support\ServiceProvider;
use Wotta\CommandExtender\Console\ExtendedRouteListCommand;

class CommandExtenderServiceProvider extends ServiceProvider
{
    protected $commands = [
        ExtendedRouteListCommand::class,
    ];

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('command-extender.php'),
            ], 'command-extender');

            $this->commands($this->commands);

            if ($this->app->runningUnitTests()) {
                $this->loadRoutesFrom(__DIR__.'/../routes/test.php');
            }
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'command-extender');

        $this->app->singleton('command-extender', function () {
            return new CommandExtender;
        });

        $this->app->extend('command.route.list', function () {
            return $this->app->make(ExtendedRouteListCommand::class);
        });
    }
}
