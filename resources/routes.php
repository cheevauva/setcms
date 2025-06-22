<?php

use SetCMS\Module\Post\Controller\PostPublicIndexController;
use SetCMS\Module\Post\Controller\PostPrivateIndexController;

$routes['GET / home'] = PostPublicIndexController::class;
$routes['GET /~ homeAdmin'] = PostPrivateIndexController::class;

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
