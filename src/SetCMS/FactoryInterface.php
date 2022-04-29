<?php

declare(strict_types=1);

namespace SetCMS;

interface FactoryInterface
{

    public function make(string $name, array $parameters = []): object;
}
