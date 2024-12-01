<?php

declare(strict_types=1);

namespace SetCMS\Application\Contract;

interface ContractFactory
{

    public function make(string $name, array $parameters = []): object;
}
