<?php

declare(strict_types=1);

use function DI\autowire;

return [
    \SetCMS\FactoryInterface::class => autowire(\SetCMS\Factory::class),
    \SetCMS\Router\RouterInterface::class => autowire(\SetCMS\Router\Router::class),
    \Psr\EventDispatcher\EventDispatcherInterface::class => autowire(\SetCMS\EventDispatcher::class),
];
