<?php

declare(strict_types=1);

namespace Tests;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;

trait TestTrait
{

    public static ContainerInterface $container;

    #[\Override]
    protected function setUp(): void
    {
        self::$container = $this->container($this->mocks());
    }

    protected function container(\Closure $mocks): ContainerInterface
    {
        return new Container($mocks);
    }

    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $c) => [
        ];
    }
}
