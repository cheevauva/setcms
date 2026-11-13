<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\UUID;
use Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use Module\ACL\VO\ACLRoleVO;
use SetCMS\Controller\Exception\ControllerEmptyResponseException;
use Laminas\Diactoros\Uri;

abstract class ViewHtml extends View
{

    use \UUA\Traits\EnvTrait;
    use \UUA\Traits\EventDispatcherTrait;
    use \SetCMS\Traits\TraitsRouter;
    use \SetCMS\Traits\TraitsResponse;
    use \SetCMS\Traits\TraitsServerRequestFactory;
    use \UUA\Traits\WrappingTrait;

    protected ?string $templateName = null;

    /**
     * @var array<string, mixed>
     */
    protected array $vars = [];

    protected function templateName(): ?string
    {
        return $this->templateName;
    }

    #[\Override]
    protected function run(): void
    {
        $templateName = $this->templateName() ?? $this->templateNameByClass();

        if (!$this->has($templateName)) {
            throw new \Exception(sprintf('path %s not found', $templateName));
        }

        $this->assign('scope', $this);
        $this->assign('scopeName', $this::class);
        $this->assign('ctx', $this->request->getAttributes());

        $this->registerFunctions();

        foreach ($this->vars as $v => $vv) {
            $this->assign($v, $vv);
        }


        $html = $this->render($templateName, get_object_vars($this));

        $response = $this->newResponse()->withStatus(200)->withHeader('Content-Type', 'text/html');
        $response->getBody()->write($html);

        $this->response = $response;
    }

    protected function registerFunctions(): void
    {
        $this->addFunction('getJson', $this->getJson(...));
        $this->addFunction('getHtml', $this->getHtml(...));
        $this->addFunction('UUID', $this->UUID(...));
        $this->addFunction('url', $this->url(...));
        $this->addFunction('scLongPath', $this->scLongPath(...));
        $this->addFunction('scShortPath', $this->scShortPath(...));
        $this->addFunction('scBaseUrl', $this->scBaseUrl(...));
        $this->addFunction('can', $this->can(...));
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
     * @param array<string, mixed>|null $params
     * @return string
     */
    protected function fetch(string $path, ?array $params = []): string
    {
        $params ??= [];

        $routerMatch = $this->router()->match($path, 'GET');

        $controller = ControllerViaPSR7::as(($routerMatch->target)::new($this->container));
        $controller->name = $routerMatch->name;
        $controller->params = $routerMatch->params;
        $controller->request = $this->request->withQueryParams($params)->withMethod('GET')->withUri(new Uri($path))->withHeader('Root-Context-Path', $this->request->getUri()->getPath())->withHeader('Root-Context-Query', $this->request->getUri()->getQuery());
        $controller->serve();

        $body = ($controller->response ?? throw new ControllerEmptyResponseException($routerMatch->target))->getBody();
        $body->rewind();

        return $body->getContents();
    }

    /**
     * @param string $path
     * @param array<string, mixed> $params
     * @return mixed
     */
    protected function getHtml(string $path, ?array $params = []): mixed
    {
        try {
            return $this->fetch($path, $params);
        } catch (\Throwable $ex) {
            error_log($ex->getMessage() . ' ' . json_encode([$path, $params, __METHOD__, $ex->getFile(), $ex->getLine()], JSON_UNESCAPED_UNICODE));

            return sprintf('<span style="color: black; background-color: red;padding: 5px">ERR: %s</span>', $path);
        }
    }

    /**
     * @param string $path
     * @param array<string, mixed> $params
     * @return array<mixed, mixed>|null
     */
    protected function getJson(string $path, ?array $params = []): ?array
    {
        try {
            $json = $this->fetch($path, $params);

            if (!json_validate($json)) {
                throw new \Exception('JSON INVALID');
            }

            return json_decode($json, true);
        } catch (\Throwable $ex) {
            error_log($ex->getMessage() . ' ' . json_encode([$path, $params, __METHOD__, $ex->getFile(), $ex->getLine()], JSON_UNESCAPED_UNICODE));

            return null;
        }
    }

    #[\ReturnTypeWillChange]
    protected function UUID(): string
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
    protected function url(string $route, array $params = [], array|string $query = []): string
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
        return sprintf('%s/resources/templates/%s', $this->rootPath(), $this->scShortPath($name));
    }

    private function templateNameByClass(): string
    {
        $reflectionClass = (new \ReflectionClass(static::class));

        $shortName = $reflectionClass->getShortName();

        if ($reflectionClass->isAnonymous()) {
            if (!$reflectionClass->getParentClass()) {
                throw new \Exception('Анонимный класс без наследования не разрешен');
            }

            $shortName = $reflectionClass->getParentClass()->getShortName();
        }

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

    protected function can(string $route): bool
    {
        return ACLCheckByRoleAndPrivilegeServant::call($this, ACLRoleVO::as($this->request->getAttribute('currentUserRole')), $route)->isAllow;
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
