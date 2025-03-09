<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;

class ViewTwigRender extends ViewHtmlRender
{

    private Environment $twig;

    protected function twig(): Environment
    {
        if (!empty($this->twig)) {
            return $this->twig;
        }

        $loader = new FilesystemLoader(sprintf('%s/resources/templates', $this->basePath()));
        $this->twig = new Environment($loader, [
            'cache' => sprintf('%s/cache/twig', $this->basePath()),
            'auto_reload' => true,
        ]);

        return $this->twig;
    }

    protected function assign(string $name, mixed $value): void
    {
        $this->twig()->addGlobal($name, $value);
    }

    protected function addFunction(string $name, \Closure $function): void
    {
        $this->twig()->addFunction(new TwigFunction($name, $function));
    }

    protected function render(string $name, array $context = []): string
    {
        return $this->twig()->render($this->scShortPath($name), $context);
    }

    #[\Override]
    protected function scRender(string $template, mixed $value = null, array $vars = []): mixed
    {
        return new Markup(parent::scRender($template, $value, $vars), 'UTF-8');
    }

    protected function scUUID(): string
    {
        return strval(parent::scUUID());
    }

    protected function scShortPath(string $name): string
    {
        $shortPath = parent::scShortPath($name);

        if (substr($shortPath, -5) !== '.twig') {
            $shortPath .= '.twig';
        }

        return $shortPath;
    }
}
