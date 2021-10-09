<?php

return [
    \SetCMS\Module\Posts\PostDAO::class => [
        'path' => ':basePath/cache/posts.db',
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    \SetCMS\Module\Users\UserDAO::class => [
        'path' => ':basePath/cache/users.db',
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
];
