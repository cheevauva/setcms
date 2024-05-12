<?php

declare(strict_types=1);

namespace SetCMS\Template;

use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;

class TemplateTwig extends TemplateGeneral
{

    use \SetCMS\QuickTrait;
    use \SetCMS\EnvTrait;

    protected TemplateEnum $templateType = TemplateEnum::Twig;
    private Environment $twig;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $loader = new FilesystemLoader(sprintf('%s/resources/templates', $this->basePath));
        $twig = new Environment($loader, [
            'cache' => sprintf('%s/cache/twig', $this->basePath),
            'auto_reload' => true,
        ]);

        foreach (get_class_methods($this) as $method) {
            if (strpos($method, 'sc') === 0) {
                $twig->addFunction(new TwigFunction($method, \Closure::fromCallable([$this, $method])->bindTo($this)));
            }
        }

        $this->twig = $twig;
    }

    public function render(string $name, array $context = []): string
    {
        return $this->twig->render($this->scShortPath($name), $context);
    }

    protected function scRender(string $method, string $path, ?string $template = null): Markup
    {
        return new Markup(parent::scRender($method, $path, $template), 'UTF-8');
    }

    protected function scUUID(): Markup
    {
        return new Markup(parent::scUUID(), 'UTF-8');
    }

}
