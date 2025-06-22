<?php

use SetCMS\Module\Post\Controller\PostPublicIndexController;
use SetCMS\Module\Post\Controller\PostPrivateIndexController;

$routes['GET / Home'] = PostPublicIndexController::class;
$routes['GET /~ AdminHome'] = PostPrivateIndexController::class;

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
