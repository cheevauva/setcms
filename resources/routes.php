<?php

use SetCMS\Controller\IndexController;
use SetCMS\Controller\AdminController;

$routes = [
    'home' => ['GET', '/', IndexController::toRoute()->resolve()],
    'home_admin' => ['GET', '/~', AdminController::toRoute()->resolve()],
    'action_record' => ['GET', '/[a:module]/[a:action]/[*:id]', IndexController::toRoute()->resolve()],
    'action' => ['GET', '/[a:module]/[a:action]', IndexController::toRoute()->resolve()],
    'do_action_record' => ['POST', '/[a:module]/[a:action]/[*:id]', IndexController::toRoute()->resolve()],
    'do_action' => ['POST', '/[a:module]/[a:action]', IndexController::toRoute()->resolve()],
    'action_record_admin' => ['GET', '/~/[a:module]/[a:action]/[*:id]/', AdminController::toRoute()->resolve()],
    'action_admin' => ['GET', '/~/[a:module]/[a:action]/', AdminController::toRoute()->resolve()],
    'do_action_record_admin' => ['POST', '/~/[a:module]/[a:action]/[*:id]', AdminController::toRoute()->resolve()],
    'do_action_admin' => ['POST', '/~/[a:module]/[a:action]/', AdminController::toRoute()->resolve()],
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
