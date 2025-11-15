<?php

declare(strict_types=1);

namespace SetCMS\Contract;

use SetCMS\Router\RouterMatchDTO;

interface ContractRouter
{

    public function match(?string $requestUrl = null, ?string $requestMethod = null): RouterMatchDTO;

    /**
     * @param string $routeName
     * @param array<(int|string)|mixed> $params
     * @return string
     */
    public function generate(string $routeName, array $params = []): string;
}
