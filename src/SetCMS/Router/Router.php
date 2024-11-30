<?php

namespace SetCMS\Router;

use SetCMS\Contract\ContractRouterInterface as RouterInterface;
use SetCMS\Router\RouterMatchDTO;
use SetCMS\Router\Exception\RouterNotFoundException;
use Psr\Container\ContainerInterface;
use AltoRouter;
use SetCMS\UUID;

class Router implements RouterInterface
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

    private AltoRouter $altoRouter;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->altoRouter = new AltoRouter;
        $this->altoRouter->setBasePath($container->get('env')['BASE_URL'] ?? '');
        $this->altoRouter->addMatchTypes([
            'g' => sprintf('(%s)++', UUID::REGEX),
        ]);

        foreach ($container->get('routes') as $name => $route) {
            $this->altoRouter->map($route[0], $route[1], $route[2], $name);
        }
    }

    public function generate($routeName, $params = []): string
    {
        return $this->altoRouter->generate($routeName, $params);
    }

    public function match($requestUrl = null, $requestMethod = null): RouterMatchDTO
    {
        $result = $this->altoRouter->match($requestUrl, $requestMethod);

        if (!$result) {
            throw new RouterNotFoundException;
        }

        $routerMatch = new RouterMatchDTO;
        $routerMatch->params = $result['params'];
        $routerMatch->target = $result['target'];
        $routerMatch->name = $result['name'];

        return $routerMatch;
    }

}
