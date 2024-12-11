<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use League\CommonMark\CommonMarkConverter;
use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Scope;
use SetCMS\View\Hook\ViewRenderHook;
use SetCMS\Module\Dynamic\DAO\DynamicMethodRetrieveByServerRequestDAO;
use SetCMS\Application\Contract\ContractRouterInterface;
use SetCMS\UUID;

abstract class ViewHtmlRender implements ContractServant, ContractApplicable
{

    use \SetCMS\Traits\QuickTrait;
    use \SetCMS\Traits\EnvTrait;

    public ?object $mixedValue = null;
    public array $vars = [];
    public ?string $html = null;
    public ?string $templateName = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $value = $this->mixedValue;

        if ($value instanceof Scope) {
            $templateName = $this->templateName ?? $this->templateNameByScope($value);

            if (!$this->has($templateName)) {
                return;
            }

            $this->assign('scope', $value);
            
            foreach (get_class_methods($this) as $method) {
                if (strpos($method, 'sc') === 0) {
                    $this->addFunction($method, \Closure::fromCallable([$this, $method]));
                }
            }

            foreach ($this->vars as $v => $vv) {
                $this->assign($v, $vv);
            }

            $this->html = $this->render($templateName, $value->toArray());
        }

        if ($value instanceof ResponseInterface) {
            $this->html = $value->getBody()->getContents();
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $this->mixedValue = $object->data;
            $this->request = $object->request;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $object->content = $this->html;
            $object->contentType = 'text/html';
        }
    }

    abstract protected function assign(string $name, mixed $value): void;

    abstract protected function render(string $name, array $context = []): string;

    abstract protected function addFunction(string $name, \Closure $function): void;

    protected function has(string $name): bool
    {
        return file_exists($this->scLongPath($name));
    }

    protected function createRequestByPath(string $path, array $params = []): ServerRequestInterface
    {
        $request = (new ServerRequestFactory)->createServerRequest('GET', new Uri($path));
        $request = $request->withAttribute('currentUser', $this->request->getAttribute('currentUser'));
        $request = $request->withAttribute('parentRequest', $this->request);
        $request = $request->withQueryParams($params);

        return $request;
    }

    #[\ReturnTypeWillChange]
    protected function scRender( string $template, mixed $value = null, array $vars = []): mixed
    {
        try {
            $htmlRender = static::make($this->factory());
            $htmlRender->request = $this->request;
            $htmlRender->mixedValue = $value;
            $htmlRender->templateName = $template;
            $htmlRender->vars = $vars;
            $htmlRender->serve();

            return $htmlRender->html;
        } catch (\Throwable $ex) {
            $content = $ex->getMessage();
        }

        return $content;
    }

    protected function scCall(string $path, array $params = []): mixed
    {
        $routerMatch = $this->router()->match($path, 'GET');

        $request = $this->createRequestByPath($path, $params);
        $request = $request->withAttribute('routeTarget', $routerMatch->target);

        foreach ($routerMatch->params as $pName => $pValue) {
            $request = $request->withAttribute($pName, $pValue);
        }

        $retrieveByPath = DynamicMethodRetrieveByServerRequestDAO::make($this->factory());
        $retrieveByPath->request = $request;
        $retrieveByPath->serve();

        foreach ($retrieveByPath->reflectionArguments as $argument) {
            if ($argument instanceof Scope) {
                $argument->from($request);
            }
        }

        return $retrieveByPath->reflectionMethod->invokeArgs($retrieveByPath->reflectionObject, $retrieveByPath->reflectionArguments);
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

    protected function templateNameByScope(Scope $scope): string
    {
        return (new \ReflectionObject($scope))->getShortName();
    }

    protected function scUriPath(): string
    {
        return $this->request->getUri()->getPath();
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
