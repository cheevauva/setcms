<?php

use SetCMS\Controller\PublicController;
use SetCMS\Controller\PrivateController;
use SetCMS\Module\Post\PostPublicController;
use SetCMS\Module\Post\PostPrivateController;

$routes = [
    'home' => ['GET', '/', PostPublicController::toRoute()->index()],
    'home_admin' => ['GET', '/~', PostPrivateController::toRoute()->index()],
    'action_record' => ['GET', '/[a:module]/[a:action]/[g:id]', PublicController::toRoute()->dynamicAction()],
    'action' => ['GET', '/[a:module]/[a:action]', PublicController::toRoute()->dynamicAction()],
    'do_action_record' => ['POST', '/[a:module]/[a:action]/[g:id]', PublicController::toRoute()->dynamicAction()],
    'do_action' => ['POST', '/[a:module]/[a:action]', PublicController::toRoute()->dynamicAction()],
    'action_record_admin' => ['GET', '/~/[a:module]/[a:action]/[g:id]', PrivateController::toRoute()->dynamicAction()],
    'action_admin' => ['GET', '/~/[a:module]/[a:action]', PrivateController::toRoute()->dynamicAction()],
    'do_action_record_admin' => ['POST', '/~/[a:module]/[a:action]/[g:id]', PrivateController::toRoute()->dynamicAction()],
    'do_action_admin' => ['POST', '/~/[a:module]/[a:action]', PrivateController::toRoute()->dynamicAction()],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
