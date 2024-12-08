<?php

declare(strict_types=1);

namespace SetCMS\Traits;

trait RouterTrait
{

    /**
     * @param string $requestMethod
     * @param string $route
     * @return static
     */
    public static function toRoute(string $requestMethod, string $route)
    {
        $controller = static::class;

        return new class($controller, $requestMethod, $route) {

            protected string $controller;
            protected string $requestMethod;
            protected string $route;

            public function __construct(string $controller, string $requestMethod, string $route)
            {
                $this->controller = $controller;
                $this->requestMethod = $requestMethod;
                $this->route = $route;
            }

            public function __call($name, $arguments)
            {
                unset($arguments);

                return [$this->requestMethod, $this->route, sprintf('%s::%s', $this->controller, $name)];
            }
        };
    }
}
