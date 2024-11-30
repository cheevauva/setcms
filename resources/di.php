<?php

declare(strict_types=1);

use function DI\autowire;

return [
    \SetCMS\Contract\Factory::class => autowire(\SetCMS\Factory::class),
    \SetCMS\Contract\ContractRouterInterface::class => autowire(\SetCMS\Application\Router\Router::class),
    \Psr\EventDispatcher\EventDispatcherInterface::class => autowire(\SetCMS\EventDispatcher::class),
];
