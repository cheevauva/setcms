<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\Controller;
use SetCMS\Module\Dynamic\DAO\DynamicMethodRetrieveByServerRequestDAO;
use SetCMS\Application\Contract\ContractRouterInterface;
use SetCMS\UUID;
use SetCMS\DTO\SetCMSOutputDTO;

abstract class ViewHtmlRender extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

    public ?object $mixedValue = null;

    /**
     * @var array<string,mixed>
     */
    public array $vars = [];
    public ?string $html = null;
    public ?string $templateName = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $value = $this->mixedValue;
        $data = new SetCMSOutputDTO();

        if ($value instanceof Controller) {
            $value->to($data);

            $templateName = $this->templateName ?? $this->templateNameByController($data->finalScope() ?? $value);

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

            $this->html = $this->render($templateName, $data->data());
        }

        if ($value instanceof ResponseInterface) {
            $this->html = $value->getBody()->getContents();
        }
    }

    abstract protected function assign(string $name, mixed $value): void;

    /**
     * @param string $name
     * @param array<string, mixed> $context
     */
    abstract protected function render(string $name, array $context = []): string;

    abstract protected function addFunction(string $name, \Closure $function): void;

    protected function has(string $name): bool
    {
        return file_exists($this->scLongPath($name));
    }

    /**
     * @param string $path
     * @param array<string,mixed> $params
     * @return ServerRequestInterface
     */
    protected function createRequestByPath(string $path, array $params = []): ServerRequestInterface
    {
        $request = (new ServerRequestFactory)->createServerRequest('GET', new Uri($path));
        $request = $request->withAttribute('currentUser', $this->request->getAttribute('currentUser'));
        $request = $request->withAttribute('parentRequest', $this->request);
        $request = $request->withQueryParams($params);

        return $request;
    }

    /**
     * @param string $template
     * @param mixed $value
     * @param array<string, mixed> $vars
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    protected function scRender(string $template, mixed $value = null, array $vars = []): mixed
    {
        try {
            $htmlRender = static::new($this->container);
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

    /**
     * @param string $path
     * @param array<string, mixed> $params
     * @return mixed
     */
    protected function scCall(string $path, array $params = []): mixed
    {
        try {
            $routerMatch = $this->router()->match($path, 'GET');
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        $request = $this->createRequestByPath($path, $params);
        $request = $request->withAttribute('routeTarget', $routerMatch->target);

        foreach ($routerMatch->params as $pName => $pValue) {
            $request = $request->withAttribute($pName, $pValue);
        }
        $retrieveByPath = DynamicMethodRetrieveByServerRequestDAO::new($this->container);
        $retrieveByPath->request = $request;
        $retrieveByPath->serve();

        $output = new SetCMSOutputDTO();

        $controller = $retrieveByPath->controller;
        $controller->from($request);
        $controller->serve();
        $controller->to($output);

        return $output->data();
    }

    /**
     * @param string $path
     * @param array<string,mixed> $params
     * @return mixed
     */
    protected function scFetch(string $path, array $params = []): mixed
    {
        try {
            $var = $this->scCall($path, $params);
        } catch (\Throwable $ex) {
            $var = $ex->getMessage();
        }

        if ($var instanceof Controller) {
            return $var->toArray();
        }

        return $var;
    }

    #[\ReturnTypeWillChange]
    protected function scUUID(): string
    {
        return strval(new UUID);
    }

    /**
     * @param string $route
     * @param array<string, mixed> $params
     * @param array<string, mixed>|string $query
     * @return string
     */
    #[\ReturnTypeWillChange]
    protected function scLink(string $route, array $params = [], array|string $query = []): string
    {
        $link = $this->router()->generate($route, $params);

        if ($query) {
            if (is_string($query)) {
                $link .= '?' . $query;
            }

            if (is_array($query)) {
                $link .= '?' . http_build_query($query);
            }
        }

        return $link;
    }

    protected function scLongPath(string $name): string
    {
        return sprintf('%s/resources/templates/%s', $this->basePath(), $this->scShortPath($name));
    }

    private function templateNameByController(Controller $controller): string
    {
        $shortName = (new \ReflectionObject($controller))->getShortName();

        if (substr($shortName, -10) === 'Controller') {
            $shortName = substr($shortName, 0, -10) . 'Scope';
        }

        return $shortName;
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
