<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;
use SetCMS\Contract\Servant;
use SetCMS\Scope;
use Throwable;
use SetCMS\Throwable\NotFound;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Contract\Factory;
use SetCMS\Contract\Router;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\UUID;
use SetCMS\RequestAttribute;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use League\CommonMark\CommonMarkConverter;

class ViewHtmlRender implements Servant
{

    use \SetCMS\QuickTrait;

    public object $mixedValue;
    public ?string $html = null;
    public ServerRequestInterface $request;

    private function router(): Router
    {
        return $this->container->get(Router::class);
    }

    private function basePath(): string
    {
        return $this->container->get('basePath');
    }

    private function config(): array
    {
        return $this->container->get('config');
    }

    private function themeName(): string
    {
        return $this->config()['theme'];
    }

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $context = $object->toArray();
            $context['currentUser'] = RequestAttribute::currentUser->fromRequest($this->request);

            $this->html = $this->getTwig()->render($this->prepareTemplateByScope($object), $context);
        }
    }

    protected function prepareTemplateByScope(Scope $scope): string
    {
        $template = explode('@', (new \ReflectionObject($scope))->getShortName())[0];

        return sprintf('themes/%s/%s', $this->themeName(), sprintf('%s.twig', $template));
    }

    protected function getTwig(): Environment
    {
        $loader = new FilesystemLoader($this->basePath() . '/resources/templates');
        $twig = new Environment($loader, [
            'cache' => $this->basePath() . '/cache/twig',
            'auto_reload' => true,
        ]);

        $theme = $this->theme();
        $theme->config = $this->config();
        $twig->addGlobal('setcms', $theme);
        $twig->addFunction(new TwigFunction('UUID', function () {
            return new Markup(strval(new UUID), 'UTF-8');
        }));
        $twig->addFunction(new TwigFunction('render', function ($route, ?string $template = null, array $params = []) {
            try {
                $content = $this->render($route, $template, $params);
            } catch (\Exception $ex) {
                $content = sprintf('Error: %s', $ex->getMessage());
            }

            return new Markup($content, 'UTF-8');
        }));

        return $twig;
    }

    protected function render(string $path, ?string $template = null, array $parsedData = [])
    {
        $request = (new ServerRequest)->withUri((new Uri)->withPath($path))->withMethod('GET')->withParsedBody($parsedData);
        $request = RequestAttribute::currentUser->toRequest($request, RequestAttribute::currentUser->fromRequest($this->request));

        $retrieveReflectionMethod = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
        $retrieveReflectionMethod->request = $request;
        $retrieveReflectionMethod->serve();

        $object = $retrieveReflectionMethod->reflectionMethod->invokeArgs($retrieveReflectionMethod->reflectionObject, $retrieveReflectionMethod->reflectionArguments);

        if ($object instanceof Scope) {
            return $this->getTwig()->render($template ?? $this->prepareTemplateByScope($object), $object->toArray());
        }

        if ($object instanceof ResponseInterface) {
            return $object->getBody()->getContents();
        }

        throw new \RuntimeException('Unsupport object');
    }

    private function theme()
    {
        return new class($this->router(), $this->themeName(), $this->request) {

            private string $theme;
            private Router $router;
            private string $self;
            private string $baseUrl;

            public function __construct(Router $router, $theme, ServerRequestInterface $request)
            {
                $this->theme = $theme;
                $this->router = clone $router;
                $this->self = $request->getServerParams()['REQUEST_SCHEME'] . '://' . $request->getServerParams()['HTTP_HOST'];
                $this->baseUrl = dirname($request->getServerParams()['SCRIPT_NAME']);

                if (substr($this->baseUrl, -1) !== '/') {
                    $this->baseUrl .= '/';
                }
            }

            public function markdown(?string $string = null): string
            {
                $converter = new CommonMarkConverter([
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                ]);

                return (string) $converter->convert(trim($string));
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
