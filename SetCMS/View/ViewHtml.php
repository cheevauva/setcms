<?php

declare(strict_types=1);

namespace SetCMS\View;

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\ControllerViaPSR7;
use SetCMS\UUID;
use SetCMS\DTO\SetCMSOutputDTO;
use SetCMS\Event\AppErrorEvent;
use SetCMS\Application\Router\Router;
use SetCMS\Application\Router\Exception\RouterNotFoundException;
use Laminas\Diactoros\Response;

abstract class ViewHtml extends \SetCMS\View
{

    use \UUA\Traits\EnvTrait;
    use \UUA\Traits\EventDispatcherTrait;

    public ?string $templateName = null;

    /**
     * @var array<string, mixed>
     */
    public array $vars = [];

    protected function templateName(): ?string
    {
        return $this->templateName;
    }

    public function serve(): void
    {
        $templateName = $this->templateName() ?? $this->templateNameByClass();

        if (!$this->has($templateName)) {
            throw new \Exception(sprintf('path %s not found', $templateName));
        }

        if (!isset($this->currentUser)) {
            throw new \Exception(sprintf('Не задан currentUser для %s', get_class($this)));
        }
        
        $this->assign('scope', $this);
        $this->assign('currentUser', $this->currentUser);

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
        $request = $request->withQueryParams($params);

        return $request;
    }

    /**
     * @param string $path`
     * @param array<string, mixed> $params
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    protected function scRender(string $path, ?array $params = []): mixed
    {
        $params = $params ?? [];

        try {
            $routerMatch = Router::singleton($this->container)->match($path, 'SETCMS');

            if (!$routerMatch) {
                throw new RouterNotFoundException(sprintf('Not found: SETCMS %s', $path));
            }

            $request = $this->createRequestByPath($path, $params);
            $request = $request->withAttribute('view', $this);
            $request = $request->withAttribute('routerMatch', $routerMatch);

            $className = $routerMatch->target;

            $controller = ControllerViaPSR7::as($className::new($this->container));
            $controller->currentUser = $this->currentUser;
            $controller->request = $request;
            $controller->serve();

            $body = $controller->response->getBody();
            $body->rewind();

            return $body->getContents();
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

//        try {
//            return $this->scCall($path, $params);
//        } catch (\Throwable $ex) {
//            (new AppErrorEvent($ex->getMessage(), [
//                __METHOD__,
//                $path,
//                $params,
//                $ex->getFile(),
//                $ex->getLine(),
//            ]))->dispatch($this->eventDispatcher());
//        }

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
}
