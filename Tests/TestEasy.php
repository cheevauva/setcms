<?php

declare(strict_types=1);

namespace Tests;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;
use UUA\ArrayObjectStrict;

class TestEasy extends \PHPUnit\Framework\TestCase
{

    public static ContainerInterface $container;

    /**
     * @var ArrayObjectStrict<string, mixed>
     */
    public static ArrayObjectStrict $env;

    /**
     * @var array<object>
     */
    public static array $events;

    /**
     * @var array<object>
     */
    public static array $wrappers;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$env = new ArrayObjectStrict([]);
        self::$events = [];
        self::$wrappers = [];
        self::$container = $this->container(fn(ContainerInterface $c) => array_merge([
            'env' => self::$env,
            'wrappers' => self::$wrappers,
        ], $this->mocks($c)));
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
        return [];
    }
}
