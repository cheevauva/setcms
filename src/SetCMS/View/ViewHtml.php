<?php

declare(strict_types=1);

namespace SetCMS\View;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\Controller;
use SetCMS\UUID;
use SetCMS\DTO\SetCMSOutputDTO;
use SetCMS\Event\AppErrorEvent;
use SetCMS\Application\Router\Router;
use SetCMS\Application\Router\RouterView;
use SetCMS\Application\Router\Exception\RouterNotFoundException;
use Laminas\Diactoros\Response;

abstract class ViewHtml extends \SetCMS\View
{

    use \UUA\Traits\EnvTrait;
    use \UUA\Traits\EventDispatcherTrait;

    /**
     * @var array<string,mixed>
     */
    public array $vars = [];
    public ServerRequestInterface $request;

    protected function templateName(): ?string
    {
        return null;
    }

    public function serve(): void
    {
        $templateName = $this->templateName() ?? $this->templateNameByClass();

        if (!$this->has($templateName)) {
            throw new \Exception(sprintf('path %s not found', $templateName));
        }

        $this->assign('scope', $this);

        foreach (get_class_methods($this) as $method) {
            if (strpos($method, 'sc') === 0) {
                $this->addFunction($method, \Closure::fromCallable([$this, $method]));
            }
        }

        foreach ($this->vars as $v => $vv) {
            $this->assign($v, $vv);
        }
        
        
        $html = $this->render($templateName, get_object_vars($this));

        $response = (new Response())->withStatus(200)->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($html);

        $this->response = $response;
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
            (new AppErrorEvent($ex->getMessage(), [
                __METHOD__,
                $template,
                $value,
                $ex->getFile(),
                $ex->getLine(),
            ]))->dispatch($this->eventDispatcher());

            return null;
        }
    }

    /**
     * @param string $path`
     * @param array<string, mixed> $params
     * @return mixed
     */
    protected function scCall(string $path, array $params = []): mixed
    {
        try {
            $routerMatch = RouterView::singleton($this->container)->match($path, 'INTERNAL');

            if (!$routerMatch) {
                throw new RouterNotFoundException(sprintf('Not found: INTERNAL %s', $path));
            }

            $request = $this->createRequestByPath($path, $params);

            $className = $routerMatch->target;

            $controller = Controller::as($className::new($this->container));
            $controller->from($request->withAttribute('routerMatch', $routerMatch));
            $controller->serve();

            return $controller;
        } catch (\Throwable $ex) {
            (new AppErrorEvent($ex->getMessage(), [
                __METHOD__,
                $path,
                $params,
                $ex->getFile(),
                $ex->getLine(),
            ]))->dispatch($this->eventDispatcher());

            return null;
        }
    }

    /**
     * @param string $path
     * @param array<string,mixed> $params
     * @return mixed
     */
    protected function scFetch(string $path, array $params = []): mixed
    {
        $data = null;

        try {
            $output = new SetCMSOutputDTO();

            $var = $this->scCall($path, $params);

            if ($var instanceof Controller) {
                $var->to($output);
                $data = $output->data();
            }
        } catch (\Throwable $ex) {
            (new AppErrorEvent($ex->getMessage(), [
                __METHOD__,
                $path,
                $params,
                $ex->getFile(),
                $ex->getLine(),
            ]))->dispatch($this->eventDispatcher());
        }

        return $data;
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
        $link = Router::singleton($this->container)->generate($route, $params);

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

    private function templateNameByClass(): string
    {
        $shortName = (new \ReflectionClass(static::class))->getShortName();

        if (substr($shortName, -4) === 'View') {
            $shortName = substr($shortName, 0, -4);
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

    protected function scBaseUrl(): string
    {
        return $this->env()['BASE_URL'] ?? '';
    }

    protected function scUser()
    {
        return $this->request->getAttribute('currentUser');
    }
}
