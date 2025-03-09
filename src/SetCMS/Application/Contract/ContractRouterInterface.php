<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

use SetCMS\Application\Router\RouterMatchDTO;

interface ContractRouterInterface
{

    public function match(?string $requestUrl = null, ?string $requestMethod = null): RouterMatchDTO;

    /**
     * @param string $routeName
     * @param array<(int|string)|mixed> $params
     * @return string
     */
    public function generate(string $routeName, array $params = []): string;
}
