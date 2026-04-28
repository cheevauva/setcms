<?php

declare(strict_types=1);

namespace Tests;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;

class TestEasy extends \PHPUnit\Framework\TestCase
{

    public static ContainerInterface $container;

    /**
     * @var array<string, mixed>
     */
    public static array $env;

    /**
     * @var array<object>
     */
    public static array $events;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$container = $this->container($this->mocks(...));
        self::$env = [];
        self::$events = [];
    }

    protected function container(\Closure $mocks): ContainerInterface
    {
        return new Container($mocks);
    }

    /**
     * @param ContainerInterface $c
     * @return array<string, mixed>
     */
    protected function mocks(ContainerInterface $c): array
    {
        return [
            'env' => array_merge($c->get('env'), self::$env)
        ];
    }
}
