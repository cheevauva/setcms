<?php

use SetCMS\Module\Dynamic\Controller\DynamicPublicController;
use SetCMS\Module\Dynamic\Controller\DynamicPrivateController;
use SetCMS\Module\Post\Controller\PostPublicIndexController;
use SetCMS\Module\Post\Controller\PostPrivateIndexController;

$routes['GET / home'] = PostPublicIndexController::class;
$routes['GET /~ home_admin'] = PostPrivateIndexController::class;
$routes['GET /[a:module]/[a:action]/[g:id] action_record'] = DynamicPublicController::class;
$routes['GET /[a:module]/[a:action] action'] = DynamicPublicController::class;
$routes['POST /[a:module]/[a:action]/[g:id] do_action_record'] = DynamicPublicController::class;
$routes['POST /[a:module]/[a:action] do_action'] = DynamicPublicController::class;
$routes['GET /~/[a:module]/[a:action]/[g:id] action_record_admin'] = DynamicPrivateController::class;
$routes['GET /~/[a:module]/[a:action] action_admin'] = DynamicPrivateController::class;
$routes['POST /~/[a:module]/[a:action]/[g:id] do_action_record_admin'] = DynamicPrivateController::class;
$routes['POST /~/[a:module]/[a:action] do_action_admin'] = DynamicPrivateController::class;

foreach (glob(__DIR__ . '/controllers/*') as $file) {
    require $file;
}

return $routes;
