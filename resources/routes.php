<?php

$routes = [
    'home' => ['GET', '/', ['action' => 'index', 'module' => 'Post', 'section' => 'Index']],
    'home_admin' => ['GET', '/~', ['action' => 'index', 'module' => 'Post', 'section' => 'Admin']],
    'action_record' => ['GET', '/[a:module]/[a:action]/[*:id]', ['section' => 'Index']],
    'action' => ['GET', '/[a:module]/[a:action]', ['section' => 'Index']],
    'do_action_record' => ['POST', '/[a:module]/[a:action]/[*:id]', ['section' => 'Index']],
    'do_action' => ['POST', '/[a:module]/[a:action]', ['section' => 'Index']],
    'action_record_admin' => ['GET', '/~/[a:module]/[a:action]/[*:id]/', ['section' => 'Admin']],
    'action_admin' => ['GET', '/~/[a:module]/[a:action]/', ['section' => 'Admin']],
    'do_action_record_admin' => ['POST', '/~/[a:module]/[a:action]/[*:id]', ['section' => 'Admin']],
    'do_action_admin' => ['POST', '/~/[a:module]/[a:action]/', ['section' => 'Admin']],
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
