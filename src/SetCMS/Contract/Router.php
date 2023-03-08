<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Router\RouterMatchDTO;

interface Router
{

    public function match($requestUrl = null, $requestMethod = null): RouterMatchDTO;

    public function generate($routeName, array $params = []): string;

    public function setBasePath(string $basePath): void;
}
