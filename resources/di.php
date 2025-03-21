<?php

declare(strict_types=1);

use function DI\autowire;

return [
    \Psr\EventDispatcher\EventDispatcherInterface::class => autowire(\SetCMS\EventDispatcher::class),
];
