<?php

declare(strict_types=1);

namespace SetCMS\Template;

use Psr\Container\ContainerInterface;
use SetCMS\Contract\Template;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;
use Twig\Markup;
use SetCMS\UUID;
use SetCMS\Contract\Router;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\RequestAttribute;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use Laminas\Diactoros\Response;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use SetCMS\Scope;
use League\CommonMark\CommonMarkConverter;

class TemplateTwig implements Template
{

    use \SetCMS\QuickTrait;
    use \SetCMS\EnvTrait;

    private Environment $twig;
    private string $basePath;
    private string $theme;
    private Router $router;
    private ServerRequestInterface $request;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->basePath = $container->get('basePath');
        $this->theme = $this->env()['THEME'];
        $this->router = $container->get(Router::class);

        $loader = new FilesystemLoader($this->basePath . '/resources/templates');
        $twig = new Environment($loader, [
            'cache' => $this->basePath . '/cache/twig',
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
        if (substr($name, -5) !== '.twig') {
            $name .= '.twig';
        }
        $context['scUser'] = RequestAttribute::currentUser->fromRequest($this->request);

        return $this->twig->render($this->scPath($name), $context);
    }

    protected function scRender($path, ?string $template = null, array $parsedData = [])
    {
        try {
            $request = (new ServerRequest)->withUri((new Uri)->withPath($path))->withMethod('GET')->withParsedBody($parsedData);
            $request = RequestAttribute::currentUser->toRequest($request, RequestAttribute::currentUser->fromRequest($this->request));

            $retrieveReflectionMethod = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
            $retrieveReflectionMethod->request = $request;
            $retrieveReflectionMethod->response = new Response;
            $retrieveReflectionMethod->serve();

            $object = $retrieveReflectionMethod->reflectionMethod->invokeArgs($retrieveReflectionMethod->reflectionObject, $retrieveReflectionMethod->reflectionArguments);

            if ($object instanceof Scope) {
                $content = $this->render($template ?? (new \ReflectionObject($object))->getShortName(), $object->toArray());
            } else {
                throw new \RuntimeException('Unsupport object');
            }
        } catch (\SetCMS\Exception $ex) {
            $content = sprintf('Error: %s', $ex->label());
        } catch (\Throwable) {
            $content = $ex->getMessage();
        }

        return new Markup($content, 'UTF-8');
    }

    protected function scUUID()
    {
        return new Markup(strval(new UUID), 'UTF-8');
    }

    protected function scMarkdown(?string $string = null): string
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return (string) $converter->convert(trim($string));
    }

    protected function scLink(string $route, $params = [], $query = ''): string
    {
        $link = $this->router->generate($route, $params);
        $link .= $query ? ('?' . (is_array($query) ? http_build_query($query) : $query)) : '';

        return $link;
    }

    protected function scPath(string $path): string
    {
        return sprintf('themes/%s/%s', $this->theme, $path);
    }

    protected function scBaseUrl(): string
    {
        return $this->env()['BASE_URL'] ?? '';
    }

    public function from(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }
    }

    public function to(object $object): void
    {
        
    }

}
