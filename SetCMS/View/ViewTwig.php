<?php

declare(strict_types=1);

namespace SetCMS\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;

class ViewTwig extends ViewHtml
{

    private Environment $twig;
    public ?string $customTemplate = null;

    protected function twig(): Environment
    {
        if (!empty($this->twig)) {
            return $this->twig;
        }

        if ($this->customTemplate) {
            $loader = new \Twig\Loader\ArrayLoader([
                'template' => $this->customTemplate,
            ]);
            $this->twig = new \Twig\Environment($loader, [
                'cache' => false
            ]);
        } else {
            $loader = new FilesystemLoader(sprintf('%s/resources/templates', $this->basePath()));
            $this->twig = new Environment($loader, [
                'cache' => sprintf('%s/cache/twig', $this->basePath()),
                'auto_reload' => true,
            ]);
        }

        return $this->twig;
    }

    #[\Override]
    protected function assign(string $name, mixed $value): void
    {
        $this->twig()->addGlobal($name, $value);
    }

    #[\Override]
    protected function addFunction(string $name, \Closure $function): void
    {
        $this->twig()->addFunction(new TwigFunction($name, $function));
    }

    #[\Override]
    protected function render(string $name, array $context = []): string
    {
        return $this->twig()->render($this->scShortPath($name), $context);
    }

    #[\Override]
    protected function scRender(string $path, ?array $params = []): mixed
    {
        return new Markup(parent::scRender($path, $params), 'UTF-8');
    }

    #[\Override]
    protected function scUUID(): string
    {
        return strval(parent::scUUID());
    }

    #[\Override]
    protected function scShortPath(string $name): string
    {
        $shortPath = parent::scShortPath($name);

        if (substr($shortPath, -5) !== '.twig') {
            $shortPath .= '.twig';
        }

        return $shortPath;
    }
}
