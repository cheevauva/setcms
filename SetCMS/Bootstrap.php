<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\EventDispatcher;

class Bootstrap
{

    private static Bootstrap $instance;

    public static function instance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function rootPath(): string
    {
        return $this->env()['ROOT_PATH'] ?? throw new \Exception('ROOT_PATH не указан');
    }

    /**
     * @return array<string, mixed>
     */
    public function env(): array
    {
        return $_ENV;
    }

    public function newContainer(): ContainerInterface
    {
        if (file_exists($this->rootPath() . '/cache/resources.php')) {
            $resources = require $this->rootPath() . '/cache/resources.php';
        } else {
            $resources = require $this->rootPath() . '/resources/resources.php';
        }

        $container = new Container(fn(Container $container) => [
            EventDispatcherInterface::class => fn(Container $container) => new EventDispatcher($container),
            'rootPath' => $this->rootPath(),
            'env' => $this->env(),
            'events' => $resources['events'],
            'acl' => $resources['acl'],
            'routes' => $resources['routes'],
            'middlewares' => $resources['middlewares'],
            'exceptionHandlers' => $resources['exceptionHandlers'],
            'entities' => $resources['entities'],
        ]);

        return $container;
    }
}
