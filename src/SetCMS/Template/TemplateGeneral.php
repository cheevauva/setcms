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
    protected function scRender($path, ?string $template = null)
    {
        if (empty($template)) {
            $template = null;
        }

        try {
            $request = $this->request;

            $uri = $request->getUri();
            $uri = $uri->withPath($path);

            $request = $request->withUri($uri)->withMethod('GET');

            $retrieveByPath = CoreReflectionMethodRetrieveByServerRequestDAO::make($this->factory());
            $retrieveByPath->request = $request;
            $retrieveByPath->serve();

            $object = $retrieveByPath->reflectionMethod->invokeArgs($retrieveByPath->reflectionObject, $retrieveByPath->reflectionArguments);

            $templateEngine = TemplateFactory::make($this->container)->create($this->templateType);
            $templateEngine->from($request);

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
