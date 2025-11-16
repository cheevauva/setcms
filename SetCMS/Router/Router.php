<?php

namespace SetCMS\Router;

use Psr\Container\ContainerInterface;
use AltoRouter;
use SetCMS\UUID;
use SetCMS\Contract\ContractRouter;
use SetCMS\Router\RouterMatchDTO;
use SetCMS\Router\Exception\RouterNotFoundException;
use SetCMS\Router\Exception\RouterRouteByNameNotFoundException;

class Router implements ContractRouter, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    private AltoRouter $altoRouter;
    protected ContainerInterface $container;

    /**
     * @var array<string, string>
     */
    protected array $routes = [];

    protected function init(): void
    {
        $this->altoRouter = new AltoRouter;
        $this->altoRouter->addMatchTypes([
            'g' => sprintf('(%s)++', UUID::REGEX),
        ]);

        foreach ($this->rules() as $rule => $controller) {
            $route = explode(' ', $rule);
            $this->altoRouter->map($route[0], $route[1], $controller, $route[2]);
            $this->routes[$route[2]] = $controller;
        }
    }

    /**
     * 
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return $this->container->get('routes');
    }

    #[\Override]
    public function generate(string $routeName, array $params = []): string
    {
        return $this->altoRouter->generate($routeName, $params);
    }

    #[\Override]
    public function match(?string $requestUrl = null, ?string $requestMethod = null): RouterMatchDTO
    {
        $result = $this->altoRouter->match($requestUrl, $requestMethod);

        if (!$result) {
            throw new RouterNotFoundException(sprintf('Маршрут: %s %s не найден', $requestMethod, $requestUrl));
        }

        $routerMatch = new RouterMatchDTO;
        $routerMatch->params = $result['params'] ?? [];
        $routerMatch->target = strval($result['target'] ?? throw new \RuntimeException('target is undefined'));
        $routerMatch->name = strval($result['name'] ?? throw new \RuntimeException('name is undefined'));

        return $routerMatch;
    }

    #[\Override]
    public function controllerByRoute(string $routeName): string
    {
        return $this->routes[$routeName] ?? throw new RouterRouteByNameNotFoundException($routeName);
    }
}
