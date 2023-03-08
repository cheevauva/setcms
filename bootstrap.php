<?php

require_once __DIR__ . '/vendor/autoload.php';

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use SetCMS\EventDispatcher;
use SetCMS\Factory;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, [
    '.env',
    '.env.dist',
]);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(require __DIR__ . '/resources/di.php');
$containerBuilder->addDefinitions([
    'basePath' => __DIR__,
    'env' => $dotenv->load(),
    'config' => require __DIR__ . '/config.php',
    'events' => require __DIR__ . '/resources/events.php',
    'acl' => require __DIR__ . '/resources/acl.php',
    'routes' => require __DIR__ . '/resources/routes.php',
    'headers' => require __DIR__ . '/resources/headers.php',
    'modules' => require __DIR__ . '/resources/modules.php',
    'themes' => require __DIR__ . '/resources/themes.php',
]);

$container = $containerBuilder->build();
$factory = Factory::as($container->get(Factory::class));
$eventDispatcher = EventDispatcher::as($container->get(EventDispatcherInterface::class));

assert($container instanceof ContainerInterface);
