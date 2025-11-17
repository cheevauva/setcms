<?php

declare(strict_types=1);

return [
    'events' => require __DIR__ . '/events.php',
    'acl' => require __DIR__ . '/acl.php',
    'routes' => require __DIR__ . '/routes.php',
    'middlewares' => require __DIR__ . '/middlewares.php',
    'exceptionHandlers' => require __DIR__ . '/exceptionHandlers.php',
];
