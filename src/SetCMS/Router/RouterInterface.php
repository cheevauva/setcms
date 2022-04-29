<?php

declare(strict_types=1);

namespace SetCMS\Router;

interface RouterInterface
{

    public function match($requestUrl = null, $requestMethod = null);

    public function generate($routeName, array $params = array());

    public function map($method, $route, $target, $name = null);
}
