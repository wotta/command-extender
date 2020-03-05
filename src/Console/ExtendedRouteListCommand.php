<?php

namespace Wotta\CommandExtender\Console;

use Composer\Autoload\ClassLoader;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Wotta\CommandExtender\Shell;

class ExtendedRouteListCommand extends RouteListCommand
{
    /** @var Shell */
    private $shell;

    public function __construct(Router $router, Shell $shell)
    {
        parent::__construct($router);

        $this->shell = $shell;
    }

    public function handle(): void
    {
        parent::handle();
    }

    protected function displayRoutes(array $routes): void
    {
        if ($this->option('open')) {
            $choices = $this->filterFileChoices($routes);

            $choice = $this->choice('Which file would you like to open?', $choices->values()->all());

            $file = $this->getFileNameFromClass($this->convertChoiceToClass($choice));

            $this->tryToOpenFileWithEditor($file);

            return;
        }

        parent::displayRoutes($routes);
    }

    protected function filterRoute(array $route): ?array
    {
        if ($this->option('action') && ! Str::contains($route['action'], $this->option('action'))) {
            return null;
        }

        return parent::filterRoute($route);
    }

    protected function getOptions(): array
    {
        return array_merge(
            parent::getOptions(),
            [
                'action' => ['action', null, InputOption::VALUE_OPTIONAL, 'Filter the routes by action'],
                'open' => ['open', 'o', InputOption::VALUE_NONE, 'Open the corresponding file for the selected route'],
            ]
        );
    }

    private function convertChoiceToClass($choice)
    {
        $choice = Str::after($choice, '<comment>');
        $choice = Str::before($choice, ':');

        return $choice;
    }

    protected function filterFileChoices(array $routes): Collection
    {
        $files = collect([]);

        $choices = collect($routes)
            ->filter(function ($route) {
                return $route['action'] !== 'Closure';
            })->filter(function ($route) use (&$files) {
                if (! Str::contains($route['action'], '@')) {
                    return;
                }

                $file = explode('@', $route['action'])[0];

                if (! $files->contains($file)) {
                    $files->push($file);

                    return $route;
                }
            })->map(function ($route) {
                return sprintf(
                    '<comment>%s:</comment> for route "%s"',
                    explode('@', $route['action'])[0],
                    $route['uri']
                );
            });

        return $choices;
    }

    private function getFileNameFromClass(string $choice)
    {
        try {
            $reflector = new ReflectionClass($choice);
        } catch (ReflectionException $exception) {
            $this->error($exception->getMessage());
            exit;
        }

        return $reflector->getFileName();
    }

    private function tryToOpenFileWithEditor(string $file)
    {
        if (config('command-extender.editor.cli')) {
            $this->shell->exec(
                sprintf(
                    '%s %s',
                    config('command-extender.editor.cli'),
                    $file
                )
            );

            return true;
        }

        if (config('command-extender.editor.path')) {
            $this->shell->exec(
                sprintf(
                    '%s %s',
                    config('command-extender.editor.path'),
                    $file
                )
            );

            return true;
        }

        return false;
    }
}
