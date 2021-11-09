<?php

return [
    \SetCMS\Database\ConnectionFactory::class => [
        'path' => ':basePath/cache/main.db',
        'driver' => 'pdo_sqlite',
        'charset' => 'UTF8',
    ],
    \SetCMS\Module\Migrations\MigrationDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\Posts\PostDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\Users\UserDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\Pages\PageDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\OAuth\OAuthClientDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\OAuth\OAuthTokenDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\OAuth\OAuthCodeDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\OAuth\OAuthUserDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\Captcha\CaptchaDAO::class => \SetCMS\Database\ConnectionFactory::class,
    \SetCMS\Module\Blocks\BlockDAO::class => \SetCMS\Database\ConnectionFactory::class,
];
