<?php

declare(strict_types=1);

use function DI\autowire;

return [
    \SetCMS\Application\Contract\ContractRouterInterface::class => autowire(\SetCMS\Application\Router\Router::class),
    \Psr\EventDispatcher\EventDispatcherInterface::class => autowire(\SetCMS\EventDispatcher::class),
];
