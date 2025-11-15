<?php

declare(strict_types=1);

namespace SetCMS\View;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\ControllerViaPSR7;
use SetCMS\UUID;
use SetCMS\Event\AppErrorEvent;
use SetCMS\Router\Router;
use SetCMS\Router\Exception\RouterNotFoundException;
use Laminas\Diactoros\Response;
use Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant; // @todo этого здесь не должно быть

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

        $this->assign('scope', $this);
        $this->assign('ctx', $this->ctx);

        $this->registerFunctions();

        foreach ($this->vars as $v => $vv) {
            $this->assign($v, $vv);
        }


        $html = $this->render($templateName, get_object_vars($this));

        $response = (new Response())->withStatus(200)->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($html);

        $this->response = $response;
    }

    protected function registerFunctions(): void
    {
        $this->addFunction('scRender', \Closure::fromCallable([$this, 'scRender']));
        $this->addFunction('scFetch', \Closure::fromCallable([$this, 'scFetch']));
        $this->addFunction('scUUID', \Closure::fromCallable([$this, 'scUUID']));
        $this->addFunction('scLink', \Closure::fromCallable([$this, 'scLink']));
        $this->addFunction('scLongPath', \Closure::fromCallable([$this, 'scLongPath']));
        $this->addFunction('scShortPath', \Closure::fromCallable([$this, 'scShortPath']));
        $this->addFunction('scBaseUrl', \Closure::fromCallable([$this, 'scBaseUrl']));
        $this->addFunction('scHasAccess', \Closure::fromCallable([$this, 'scHasAccess']));
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
     * @param string $path`
     * @param array<string, mixed> $params
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    protected function scRender(string $path, ?array $params = []): mixed
    {
        $params ??= [];

        try {
            $routerMatch = Router::singleton($this->container)->match($path, 'SETCMS');

            if (!$routerMatch) {
                throw new RouterNotFoundException(sprintf('Не найден маршрут: SETCMS %s', $path));
            }

            $ctx = $this->ctx;
            $ctx['view'] = $this;

            $className = $routerMatch->target;

            $controller = ControllerViaPSR7::as($className::new($this->container));
            $controller->name = $routerMatch->name;
            $controller->params = $routerMatch->params;
            $controller->ctx = $ctx;
            $controller->request = (new ServerRequestFactory)->createServerRequest('GET', new Uri($path))->withQueryParams($params);
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
        return sprintf('%s/resources/templates/%s', $this->rootPath(), $this->scShortPath($name));
    }

    private function templateNameByClass(): string
    {
        $shortName = (new \ReflectionClass(static::class))->getShortName();

        if (substr($shortName, -4) === 'View') {
            $shortName = substr($shortName, 0, -4);
        }

        return $shortName;
    }

    protected function scShortPath(string $name): string
    {
        if (str_contains($name, '@')) {
            $name = explode('@', $name)[0];
        }

        return sprintf('themes/%s/%s', $this->theme(), $name);
    }

    protected function scHasAccess(string $route): bool
    {
        $checkRole = ACLCheckByRoleAndPrivilegeServant::new($this->container);
        $checkRole->role = $this->ctx['currentUserRole'];
        $checkRole->throwExceptions = false;
        $checkRole->privilege = $route;
        $checkRole->serve();

        return $checkRole->isAllow;
    }

    protected function rootPath(): string
    {
        return $this->container->get('rootPath');
    }

    protected function theme(): string
    {
        return $this->env()['TEMPLATE'] ?? throw new \Exception('TEMPLATE нужно указать в переменных окружения');
    }

    protected function scBaseUrl(): string
    {
        return $this->env()['BASE_URL'] ?? '';
    }
}
