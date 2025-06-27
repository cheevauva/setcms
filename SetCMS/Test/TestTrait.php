<?php

declare(strict_types=1);

namespace SetCMS\Test;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;

trait TestTrait
{

    protected function container(\Closure $mocks): ContainerInterface
    {
        return new Container($mocks);
    }
}
