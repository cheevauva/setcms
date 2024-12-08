<?php

use SetCMS\Module\Dynamic\Controller\DynamicPublicController;
use SetCMS\Module\Dynamic\Controller\DynamicPrivateController;
use SetCMS\Module\Post\Controller\PostPublicController;
use SetCMS\Module\Post\Controller\PostPrivateController;

$routes = [
    'home' => PostPublicController::toRoute('GET', '/')->index(),
    'home_admin' => PostPrivateController::toRoute('GET', '/~')->index(),
    'action_record' => DynamicPublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]')->action(),
    'action' => DynamicPublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]')->action(),
    'do_action_record' => DynamicPublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]')->action(),
    'do_action' => DynamicPublicController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]')->action(),
    'action_record_admin' => DynamicPrivateController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]')->action(),
    'action_admin' => DynamicPrivateController::toRoute('GET|POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]')->action(),
    'do_action_record_admin' => DynamicPrivateController::toRoute('POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]')->action(),
    'do_action_admin' => DynamicPrivateController::toRoute('POST|DELETE|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]')->action(),
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
