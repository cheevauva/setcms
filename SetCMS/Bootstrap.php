<?php

declare(strict_types=1);

namespace SetCMS;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\EventDispatcher;
use Dotenv\Dotenv;

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
        return dirname(__DIR__);
    }

    /**
     * @return array<string, mixed>
     */
    public function env(): array
    {
        return Dotenv::createArrayBacked($this->rootPath(), ['.env', '.env.dist'])->load();
    }

    public function newContainer(): ContainerInterface
    {
        $container = new Container(fn(Container $container) => [
            EventDispatcherInterface::class => fn(Container $container) => new EventDispatcher($container),
            'basePath' => $this->rootPath(),
            'env' => $this->env(),
            'events' => require $this->rootPath() . '/resources/events.php',
            'acl' => require $this->rootPath() . '/resources/acl.php',
            'routes' => require $this->rootPath() . '/resources/routes.php',
            'headers' => require $this->rootPath() . '/resources/headers.php',
            'modules' => require $this->rootPath() . '/resources/modules.php',
            'themes' => require $this->rootPath() . '/resources/themes.php',
        ]);

        return $container;
    }
}
