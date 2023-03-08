<?php

declare(strict_types=1);

namespace SetCMS\Contract;

interface Factory
{

    public function make(string $name, array $parameters = []): object;
}
