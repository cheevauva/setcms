<?php

declare(strict_types=1);

namespace SetCMS\Template;

use Psr\Http\Message\ServerRequestInterface;
use League\CommonMark\CommonMarkConverter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\UUID;
use SetCMS\Scope;
use SetCMS\Contract\ContractRouterInterface;
use SetCMS\Contract\ContractTemplateEngineInterface;
use SetCMS\Contract\Applicable;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use SetCMS\Servant\ViewHtmlRender;

abstract class TemplateGeneral implements ContractTemplateEngineInterface, Applicable
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\EnvTrait;

    protected ServerRequestInterface $request;
    protected array $path2vars = [];

    public function from(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }
    }

    public function to(object $object): void
    {
        // nothing
    }

    public function has(string $name): bool
    {
        return file_exists($this->scLongPath($name));
    }

    protected function scBindPathToVars(string $path, string $var, mixed $value): void
    {
        $this->path2vars[$path][$var] = $value;
    }

    #[\ReturnTypeWillChange]
    protected function scRender(string $path, string $template, array $params = []): mixed
    {
        try {
            $value = $this->scCall($path, $params);

            $htmlRender = ViewHtmlRender::make($this->factory());
            $htmlRender->request = $this->createRequestByPath($path, $params);
            $htmlRender->mixedValue = $value;
            $htmlRender->templateName = $template;
            $htmlRender->vars = $this->path2vars[$template] ?? [];
            $htmlRender->serve();

            return $htmlRender->html;
        } catch (\Throwable $ex) {
            $content = $ex->getMessage();
        }

        return $content;
    }

    protected function createRequestByPath(string $path, array $params = []): ServerRequestInterface
    {
        $request = (new ServerRequestFactory)->createServerRequest('GET', new Uri($path));
        $request = $request->withAttribute('currentUser', $this->request->getAttribute('currentUser'));
        $request = $request->withAttribute('parentRequest', $this->request);
        $request = $request->withQueryParams($params);

        return $request;
    }

    protected function scUriPath(): string
    {
        return $this->request->getUri()->getPath();
    }

    protected function scFetch(string $path, array $params = []): mixed
    {
        try {
            $var = $this->scCall($path, $params);
        } catch (\Throwable $ex) {
            $var = $ex->getMessage();
        }

        if ($var instanceof Scope) {
            return $var->toArray();
        }

        return $var;
    }

    protected function scCall(string $path, array $params = []): mixed
    {
        $routerMatch = $this->router()->match($path, 'GET');
        
        $request = $this->createRequestByPath($path, $params);
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
        $link = $this->router()->generate($route, $params);
        $link .= $query ? ('?' . (is_array($query) ? http_build_query($query) : $query)) : '';

        return $link;
    }

    protected function scLongPath(string $name): string
    {
        return sprintf('%s/resources/templates/%s', $this->basePath(), $this->scShortPath($name));
    }

    protected function scShortPath(string $name): string
    {
        if (str_contains($name, '@')) {
            $name = explode('@', $name)[0];
        }

        return sprintf('themes/%s/%s', $this->theme(), $name);
    }

    protected function basePath(): string
    {
        return $this->container->get('basePath');
    }

    protected function theme(): string
    {
        return $this->env()['TEMPLATE'];
    }

    protected function router(): ContractRouterInterface
    {
        return $this->container->get(ContractRouterInterface::class);
    }

    protected function scBaseUrl(): string
    {
        return $this->env()['BASE_URL'] ?? '';
    }

    protected function scUser()
    {
        return $this->request->getAttribute('currentUser');
    }

}
