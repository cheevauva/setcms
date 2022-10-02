<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;
use SetCMS\ServantInterface;
use SetCMS\Scope;
use Throwable;
use SetCMS\Module\Themes\Theme;
use SetCMS\Throwable\NotFound;
use SetCMS\Servant\BuildMixedValueByRouteServant;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\UUID;

class BuildHtmlContentByMixedValue implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private string $basePath;
    private string $theme;
    private array $config;
    public object $mixedValue;
    public string $htmlContent;
    public ServerRequestInterface $request;
    private FactoryInterface $factory;
    private RouterInterface $router;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->router = $container->get(RouterInterface::class);
        $this->basePath = $container->get('basePath');
        $this->config = $container->get('config');
        $this->theme = $this->config['theme'];
    }

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $template = explode('@', (new \ReflectionObject($object))->getShortName())[0];

            $context = $object->toArray();

            if ($object->messages) {
                $this->htmlContent = $this->getTwig()->render('themes/bootstrap5/errors.twig', [
                    'messages' => $object->messages,
                ]);
            } else {
                $this->htmlContent = $this->getTwig()->render(sprintf('themes/%s/%s', $this->theme, sprintf('%s.twig', $template)), $context);
            }
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

        $theme = $this->theme();
        $theme->theme = $this->theme;
        $theme->config = $this->config;
        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new TwigFunction('UUID', function () {
            return new Markup(strval(new UUID), 'UTF-8');
        }));
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

        if ($object instanceof Scope) {
            return $this->getTwig()->render($template, $object->toArray());
        }

        if ($object instanceof ResponseInterface) {
            return $this->getTwig()->render($template, ['content' => $object->getBody()->getContents()]);
        }

        throw new \RuntimeException('Unsupport object');
    }

    private function theme()
    {
        return new class($this->router, $this->request) {

            private RouterInterface $router;
            private string $self;
            private string $baseUrl;

            public function __construct(RouterInterface $router, ServerRequestInterface $request)
            {
                $this->router = clone $router;
                $this->router->setBasePath(rtrim($request->getServerParams()['SCRIPT_NAME'], '/'));
                $this->self = $request->getServerParams()['REQUEST_SCHEME'] . '://' . $request->getServerParams()['HTTP_HOST'];
                $this->baseUrl = dirname($request->getServerParams()['SCRIPT_NAME']);

                if (substr($this->baseUrl, -1) !== '/') {
                    $this->baseUrl .= '/';
                }
            }

            public function markdown(?string $string = null): string
            {
                $pd = new \Parsedown;
                $pd->setSafeMode(true);

                return $pd->text($string);
            }

            public function link2(string $route, $params = [], $query = ''): string
            {
                return $this->self . $this->link($route, $params, $query);
            }

            public function link(string $route, $params = [], $query = ''): string
            {
                $link = $this->router->generate($route, $params);
                $link .= $query ? ('?' . (is_array($query) ? http_build_query($query) : $query)) : '';

                return $link;
            }

            public function path(string $path): string
            {
                return sprintf('themes/%s/%s', $this->theme, $path);
            }
        };
    }

}
