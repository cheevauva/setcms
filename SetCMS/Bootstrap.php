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
        $container = new Container(fn(Container $container) => [
            EventDispatcherInterface::class => fn(Container $container) => new EventDispatcher($container),
            'rootPath' => $this->rootPath(),
            'env' => $this->env(),
            'events' => require $this->rootPath() . '/resources/events.php',
            'acl' => require $this->rootPath() . '/resources/acl.php',
            'routes' => require $this->rootPath() . '/resources/routes.php',
            'themes' => require $this->rootPath() . '/resources/themes.php',
            'middlewares' => require $this->rootPath() . '/resources/middlewares.php',
            'exceptionHandlers' => require $this->rootPath() . '/resources/exceptionHandlers.php',
        ]);

        return $container;
    }
}
