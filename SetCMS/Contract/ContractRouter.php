<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Router\RouterRouteDTO;

interface ContractRouter
{

    public function match(?string $requestUrl = null, ?string $requestMethod = null): RouterRouteDTO;

    /**
     * @param string $routeName
     * @param array<(int|string)|mixed> $params
     * @return string
     */
    public function generate(string $routeName, array $params = []): string;
}
