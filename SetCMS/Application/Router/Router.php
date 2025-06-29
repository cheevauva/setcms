<?php

namespace SetCMS\Application\Router;

use SetCMS\Application\Contract\ContractRouterInterface as RouterInterface;
use SetCMS\Application\Router\RouterMatchDTO;
use Psr\Container\ContainerInterface;
use AltoRouter;
use SetCMS\UUID;

class Router implements RouterInterface, \UUA\ContainerConstructInterface
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

    public function generate(string $routeName, array $params = []): string
    {
        return $this->altoRouter->generate($routeName, $params);
    }

    public function match(?string $requestUrl = null, ?string $requestMethod = null): ?RouterMatchDTO
    {
        $result = $this->altoRouter->match($requestUrl, $requestMethod);

        if (!$result) {
            return null;
        }

        $routerMatch = new RouterMatchDTO;
        $routerMatch->params = $result['params'] ?? [];
        $routerMatch->target = strval($result['target'] ?? throw new \RuntimeException('target is undefined'));
        $routerMatch->name = strval($result['name'] ?? throw new \RuntimeException('name is undefined'));

        return $routerMatch;
    }

    public function controllerByRoute(string $route): string
    {
        return $this->routes[$route] ?? throw new \RuntimeException(sprintf('%s не определен', $route));
    }
}
