<?php

namespace Wotta\CommandExtender\Console\Extended;

use Illuminate\Foundation\Console\RouteListCommand as BaseRouteListCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Console\Input\InputOption;
use Wotta\CommandExtender\Shell;

class RouteListCommand extends BaseRouteListCommand
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

            $choice = $choices->values()->first();

            if ($choices->values()->count() > 1) {
                $choice = $this->choice('Which file would you like to open?', $choices->values()->all());
            }

            $file = $this->getFileNameFromClass($this->convertChoiceToClass($choice));

            if (! $this->canOpenFileWithEditor($file)) {
                $this->error('Could not open file in editor because not editor was set.');
            }

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
                'editor' => ['editor', 'e', InputOption::VALUE_OPTIONAL, 'Editor path that will be used to open files'],
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

    private function canOpenFileWithEditor(string $file): bool
    {
        $editor = $this->option('editor') ??
            config('command-extender.editor.cli') ??
            config('command-extender.editor.path') ??
            false;

        if (! $editor) {
            return false;
        }

        $this->shell->exec(
            sprintf('%s %s',
                $editor,
                $file
            )
        );

        return true;
    }
}
