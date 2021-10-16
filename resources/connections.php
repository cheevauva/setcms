<?php

return [
    \SetCMS\Module\Migrations\MigrationDAO::class => [
        'path' => ':basePath/cache/main.db', // migrations.db
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    \SetCMS\Module\Posts\PostDAO::class => [
        'path' => ':basePath/cache/main.db', // posts.db
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    \SetCMS\Module\Users\UserDAO::class => [
        'path' => ':basePath/cache/main.db', // users.db
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    SetCMS\Module\Pages\PageDAO::class => [
        'path' => ':basePath/cache/main.db', // pages.db
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    SetCMS\Module\OAuth\OAuthClientDAO::class => [
        'path' => ':basePath/cache/main.db', 
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    \SetCMS\Module\OAuth\OAuthTokenDAO::class => [
        'path' => ':basePath/cache/main.db',
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
];
