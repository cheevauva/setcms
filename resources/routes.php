<?php

$routes = [
    ['GET', '/', ['action' => 'index', 'module' => 'Post', 'section' => 'Index'], 'home'],
    ['GET', '/~', ['action' => 'index', 'module' => 'Post', 'section' => 'Admin'], 'home_admin'],
    ['GET', '/[a:module]/[a:action]/[*:id]', ['section' => 'Index'], 'action_record'],
    ['GET', '/[a:module]/[a:action]', ['section' => 'Index'], 'action'],
    ['POST', '/[a:module]/[a:action]/[*:id]', ['section' => 'Index'], 'do_action_record'],
    ['POST', '/[a:module]/[a:action]', ['section' => 'Index'], 'do_action'],
    ['GET', '/~/[a:module]/[a:action]/[*:id]/', ['section' => 'Admin'], 'action_record_admin'],
    ['GET', '/~/[a:module]/[a:action]/', ['section' => 'Admin'], 'action_admin'],
    ['POST', '/~/[a:module]/[a:action]/[*:id]', ['section' => 'Admin'], 'do_action_record_admin'],
    ['POST', '/~/[a:module]/[a:action]/', ['section' => 'Admin'], 'do_action_admin'],
    ['GET', '/-/[a:module]/[a:resource]/', ['section' => 'Resource', 'action' => 'index'], 'resource_index'],
    ['POST', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'create'], 'resource_create'],
    ['GET', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'read'], 'resource_read'],
    ['PUT', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'update'], 'resource_update'],
    ['DELETE', '/-/[a:module]/[a:resource]/[*:id]', ['section' => 'Resource', 'action' => 'delete'], 'resource_delete'],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
