<?php

declare(strict_types=1);

namespace SetCMS\Template;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use League\CommonMark\CommonMarkConverter;
use SetCMS\Contract\Router;
use SetCMS\UUID;
use SetCMS\Contract\Applicable;
use SetCMS\Scope;
use SetCMS\Template\TemplateEnum;
use SetCMS\Template\TemplateFactory;
use SetCMS\RequestAttribute;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use SetCMS\Template\DTO\TemplateScCallDTO;

abstract class TemplateGeneral implements \SetCMS\Contract\Template, Applicable
{

    use \SetCMS\DITrait;

    protected TemplateEnum $templateType;
    protected string $basePath;
    protected string $template;
    protected Router $router;
    protected ServerRequestInterface $request;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->basePath = $container->get('basePath');
        $this->template = $this->env()['TEMPLATE'];
        $this->router = $container->get(Router::class);
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

    public function has(string $name): bool
    {
        return file_exists($this->scLongPath($name));
    }

    #[\ReturnTypeWillChange]
    protected function scRender(string $method, string $path, ?string $template = null)
    {
        if (empty($template)) {
            $template = null;
        }

        try {
            $object = $this->scCall($method, $path);

            $templateEngine = TemplateFactory::make($this->container)->create($this->templateType);
            $templateEngine->from($this->request->withUri($this->request->getUri()->withPath($path))->withMethod('GET'));

            if ($object instanceof Scope) {
                return $templateEngine->render($template ?? (new \ReflectionObject($object))->getShortName(), $object->toArray());
            }

            if ($object instanceof ResponseInterface) {
                return $object->getBody()->getContents();
            }

            return '';
        } catch (\SetCMS\Exception $ex) {
            $content = sprintf('Error: %s', $ex->label());
        } catch (\Throwable $ex) {
            $content = $ex->getMessage();
        }

        return $content;
    }

    protected function scUriPath(): string
    {
        return $this->request->getUri()->getPath();
    }

    protected function scFetch(string $method, string $path): mixed
    {
        $var = $this->scCall($method, $path);

        if ($var instanceof Scope) {
            return $var->toArray();
        }

        return $var;
    }

    protected function scCall(string $method, string $path): mixed
    {
        try {
            $routerMatch = $this->router->match(...[
                $path,
                $method,
            ]);

            $request = $this->request->withUri($this->request->getUri()->withPath($path))->withMethod('GET');
            $request = $request->withAttribute('routeTarget', $routerMatch->target);

            foreach ($routerMatch->params as $pName => $pValue) {
                $request = $request->withAttribute($pName, $pValue);
            }

            $retrieveByPath = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
            $retrieveByPath->request = $request;
            $retrieveByPath->serve();

            foreach ($retrieveByPath->reflectionArguments as $argument) {
                if ($argument instanceof Scope) {
                    $argument->from($request);
                }
            }

            return $retrieveByPath->reflectionMethod->invokeArgs($retrieveByPath->reflectionObject, $retrieveByPath->reflectionArguments);
        } catch (\Throwable $ex) {
            return $ex->getMessage();
        }
    }

    #[\ReturnTypeWillChange]
    protected function scUUID()
    {
        return strval(new UUID);
    }

    #[\ReturnTypeWillChange]
    protected function scMarkdown(?string $string = null)
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

    protected function scLongPath(string $name): string
    {
        return sprintf('%s/resources/templates/%s', $this->basePath, $this->scShortPath($name));
    }

    protected function scShortPath(string $name): string
    {
        if (str_contains($name, '@')) {
            $name = explode('@', $name)[0];
        }

        if (substr($name, -5) !== '.twig') {
            $name .= '.twig';
        }

        return sprintf('themes/%s/%s', $this->template, $name);
    }

    protected function scBaseUrl(): string
    {
        return $this->env()['BASE_URL'] ?? '';
    }

    protected function scUser()
    {
        return RequestAttribute::currentUser->fromRequest($this->request);
    }

}
