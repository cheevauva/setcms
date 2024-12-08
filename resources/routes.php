<?php

use SetCMS\Core\Controller\CorePublicController;
use SetCMS\Core\Controller\CorePrivateController;
use SetCMS\Module\Post\Controller\PostPublicController;
use SetCMS\Module\Post\Controller\PostPrivateController;

$routes = [
    'home' => PostPublicController::toRoute('GET', '/')->index(),
    'home_admin' => PostPrivateController::toRoute('GET', '/~')->index(),
    'action_record' => CorePublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]')->dynamicAction(),
    'action' => CorePublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]')->dynamicAction(),
    'do_action_record' => CorePublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]')->dynamicAction(),
    'do_action' => CorePublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]')->dynamicAction(),
    'action_record_admin' => CorePrivateController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]')->dynamicAction(),
    'action_admin' => CorePrivateController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]')->dynamicAction(),
    'do_action_record_admin' => CorePrivateController::toRoute('POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]')->dynamicAction(),
    'do_action_admin' => CorePrivateController::toRoute('POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]')->dynamicAction(),
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
