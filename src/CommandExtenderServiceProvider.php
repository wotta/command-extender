<?php

namespace Wotta\CommandExtender;

use Illuminate\Support\ServiceProvider;
use Wotta\CommandExtender\Console\Extended\MakeControllerCommand;
use Wotta\CommandExtender\Console\Extended\RouteListCommand;

class CommandExtenderServiceProvider extends ServiceProvider
{
    protected $commands = [
        RouteListCommand::class,
        MakeControllerCommand::class,
    ];

    protected $extendedCommands = [
        'command.route.list' => RouteListCommand::class,
        'command.controller.make' => MakeControllerCommand::class,
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

        foreach ($this->extendedCommands as $abstract => $extendedCommand) {
            $this->app->extend($abstract, function () use ($extendedCommand) {
                return $this->app->make($extendedCommand);
            });
        }

    }
}
