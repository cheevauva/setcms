<?php

use SetCMS\Core\CorePublicController;
use SetCMS\Core\CorePrivateController;
use SetCMS\Module\Post\PostPublicController;
use SetCMS\Module\Post\PostPrivateController;

$routes = [
    'home' => ['GET', '/', PostPublicController::toRoute()->index()],
    'home_admin' => ['GET', '/~', PostPrivateController::toRoute()->index()],
    'action_record' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]', CorePublicController::toRoute()->dynamicAction()],
    'action' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]', CorePublicController::toRoute()->dynamicAction()],
    'do_action_record' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]/[g:id]', CorePublicController::toRoute()->dynamicAction()],
    'do_action' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/[a:module]/[a:action]', CorePublicController::toRoute()->dynamicAction()],
    'action_record_admin' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]', CorePrivateController::toRoute()->dynamicAction()],
    'action_admin' => ['GET|POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]', CorePrivateController::toRoute()->dynamicAction()],
    'do_action_record_admin' => ['POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]/[g:id]', CorePrivateController::toRoute()->dynamicAction()],
    'do_action_admin' => ['POST|DELETE|HEAD|PUT|OPTIONS|PATCH', '/~/[a:module]/[a:action]', CorePrivateController::toRoute()->dynamicAction()],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
