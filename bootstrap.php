<?php

require_once __DIR__ . '/vendor/autoload.php';

use UUA\Container\Container;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\EventDispatcher;
use Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__, ['.env', '.env.dist'])->load();

$container = new Container([
    EventDispatcherInterface::class => fn(Container $container) => new EventDispatcher($container),
    'fake' => require __DIR__ . '/resources/fake.php',
    'basePath' => __DIR__,
    'env' => $_ENV,
    'events' => require __DIR__ . '/resources/events.php',
    'acl' => require __DIR__ . '/resources/acl.php',
    'controllers' => require __DIR__ . '/resources/controllers.php',
    'views' => require __DIR__ . '/resources/views.php',
    'headers' => require __DIR__ . '/resources/headers.php',
    'modules' => require __DIR__ . '/resources/modules.php',
    'themes' => require __DIR__ . '/resources/themes.php',
]);

return $container;
