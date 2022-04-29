<?php

namespace SetCMS\Router;

use Psr\Container\ContainerInterface;

class Router extends \AltoRouter implements RouterInterface
{

    public function __construct(ContainerInterface $container)
    {
        foreach ($container->get('routes') as $name => $route) {
            $this->map($route[0], $route[1], $route[2], $name);
        }
    }

    public function match($requestUrl = null, $requestMethod = null)
    {
        $result = parent::match($requestUrl, $requestMethod);

        if (is_array($result)) {
            $result['target']['method'] = $requestMethod;
        }

        return $result;
    }

}
