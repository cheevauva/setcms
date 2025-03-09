<?php

declare(strict_types=1);

namespace UUA;

abstract class Unit implements UnitInterface
{

    use Traits\AsTrait;

    abstract public function serve(): void;
}
