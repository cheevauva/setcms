<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Router\RouterMatchDTO;

interface ContractRouterInterface
{

    public function match($requestUrl = null, $requestMethod = null): RouterMatchDTO;

    public function generate($routeName, array $params = []): string;
}
