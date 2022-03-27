<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;
use SetCMS\Core\ServantInterface;
use SetCMS\Core\Form;
use Throwable;
use SetCMS\Module\Themes\Theme;
use SetCMS\Throwable\NotFound;
use SetCMS\Servant\MatchRouteByRequestServant;
use SetCMS\Servant\BuildMixedValueByRouteServant;
use Psr\Http\Message\ResponseInterface;

class BuildHtmlContentByMixedValue implements ServantInterface
{

    private string $basePath;
    private string $theme;
    private array $config;
    public object $mixedValue;
    public string $htmlContent;

    public function __construct(ContainerInterface $container)
    {
        $this->basePath = $container->get('basePath');
        $this->config = $container->get('config');
        $this->theme = $this->config['theme'];
        $this->router = $container->get();
    }

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Form) {
            $this->htmlContent = $this->getTwig()->render(sprintf('themes/%s/%s', $this->theme, $this->template), $object->toArray());
        }

        if ($object instanceof Throwable) {
            $this->htmlContent = $this->getTwig()->render($this->prepareTemplateByException($object), [
                'message' => $object->getMessage(),
                'trace' => $object->getTraceAsString(),
            ]);
        }
    }

    protected function prepareTemplateByException(Throwable $ex): string
    {
        $template = 'themes/bootstrap5/error.twig';

        if ($ex instanceof NotFound) {
            $template = 'themes/bootstrap5/404.twig';
        }

        return $template;
    }

    protected function getTwig(): Environment
    {
        $loader = new FilesystemLoader($this->basePath . '/resources/templates');
        $twig = new Environment($loader, [
            'cache' => $this->basePath . '/cache/twig',
            'auto_reload' => true,
        ]);

        $theme = new Theme($this->theme);
        $theme->config = $this->config;
        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new TwigFunction('render', function ($route, $template, $params = []) {
            try {
                $content = $this->render($route, $template, $params);
            } catch (\Exception $ex) {
                $content = sprintf('Error: %s', $ex->getMessage());
            }

            return new Markup($content, 'UTF-8');
        }));

        return $twig;
    }

    protected function render(string $route, string $template, array $params = [])
    {
        $buildMixedValueByRout = new BuildMixedValueByRouteServant($this->container);
        $buildMixedValueByRout->route = $route;
        $buildMixedValueByRout->params = $params;
        $buildMixedValueByRout->serve();

        $object = $buildMixedValueByRout->mixedValue;

        if ($object instanceof Form) {
            return $this->getTwig()->render($template, $object->toArray());
        }

        if ($object instanceof ResponseInterface) {
            return $this->getTwig()->render($template, ['content' => $object->getBody()->getContents()]);
        }

        throw new \RuntimeException('Unsupport object');
    }

}
