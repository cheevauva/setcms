<?php

use SetCMS\Controller\PublicController;
use SetCMS\Controller\PrivateController;
use SetCMS\Module\Post\PostPublicController;
use SetCMS\Module\Post\PostAdminController;

$routes = [
    'home' => ['GET', '/', PostPublicController::toRoute()->index()],
    'home_admin' => ['GET', '/~', PostAdminController::toRoute()->index()],
    'action_record' => ['GET', '/[a:module]/[a:action]/[*:id]', PublicController::toRoute()->resolve()],
    'action' => ['GET', '/[a:module]/[a:action]', PublicController::toRoute()->resolve()],
    'do_action_record' => ['POST', '/[a:module]/[a:action]/[*:id]', PublicController::toRoute()->resolve()],
    'do_action' => ['POST', '/[a:module]/[a:action]', PublicController::toRoute()->resolve()],
    'action_record_admin' => ['GET', '/~/[a:module]/[a:action]/[*:id]/', PrivateController::toRoute()->resolve()],
    'action_admin' => ['GET', '/~/[a:module]/[a:action]/', PrivateController::toRoute()->resolve()],
    'do_action_record_admin' => ['POST', '/~/[a:module]/[a:action]/[*:id]', PrivateController::toRoute()->resolve()],
    'do_action_admin' => ['POST', '/~/[a:module]/[a:action]/', PrivateController::toRoute()->resolve()],
    'resource_index' => ['GET', '/-/[a:module]/[a:resource]/', ['section' => 'Resource', 'action' => 'index']],
    'resource_create' => ['POST', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'create']],
    'resource_read' => ['GET', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'read']],
    'resource_update' => ['PUT', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'update']],
    'resource_delete' => ['DELETE', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'delete']],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
