<?php

namespace Wotta\IlluminateExtender;

use Illuminate\Support\ServiceProvider;
use Wotta\IlluminateExtender\Console\Extended\KeyGenerateCommand;
use Wotta\IlluminateExtender\Console\Extended\MakeControllerCommand;
use Wotta\IlluminateExtender\Console\Extended\RouteListCommand;

class IlluminateExtenderServiceProvider extends ServiceProvider
{
    protected $commands = [
        RouteListCommand::class,
        MakeControllerCommand::class,
        KeyGenerateCommand::class,
    ];

    protected $extendedCommands = [
        'command.route.list' => RouteListCommand::class,
        'command.controller.make' => MakeControllerCommand::class,
        'command.key.generate' => KeyGenerateCommand::class,
    ];

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('illuminate-extender.php'),
            ], 'illuminate-extender');

            $this->commands($this->commands);

            if ($this->app->runningUnitTests()) {
                $this->loadRoutesFrom(__DIR__.'/../tests/Fixtures/routes/test.php');
            }
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'illuminate-extender');

        $this->app->singleton('illuminate-extender', function () {
            return new IlluminateExtender;
        });

        foreach ($this->extendedCommands as $abstract => $extendedCommand) {
            $this->app->extend($abstract, function () use ($extendedCommand) {
                return $this->app->make($extendedCommand);
            });
        }
    }
}
