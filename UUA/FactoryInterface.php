<?php

declare(strict_types=1);

namespace UUA;

interface FactoryInterface
{

    public function make(string $id): object;
}
