<?php

use SetCMS\Module\Post\Controller\PostPublicIndexController;
use SetCMS\Module\Post\Controller\PostPrivateIndexController;

$routes['GET / home'] = PostPublicIndexController::class;
$routes['GET /~ home_admin'] = PostPrivateIndexController::class;

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
