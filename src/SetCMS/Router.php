<?php

namespace SetCMS;

use Psr\Container\ContainerInterface;

class Router extends \AltoRouter
{

    public function __construct(ContainerInterface $container)
    {
        $this->addRoutes($container->get('routes'));
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
