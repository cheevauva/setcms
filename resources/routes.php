<?php

$routes = [
    ['GET', '/', ['action' => 'index', 'module' => 'Posts'], 'home'],
    ['GET', '/admin', ['action' => 'index', 'module' => 'Posts', 'section' => 'Admin'], 'home_admin'],
    ['GET', '/[a:module]/[a:action]/[a:id]', ['section' => 'Index'], 'action_record'],
    ['GET', '/[a:module]/[a:action]', ['section' => 'Index'], 'action'],
    ['POST', '/[a:module]/[a:action]/[a:id]', ['section' => 'Index'], 'do_action_record'],
    ['POST', '/[a:module]/[a:action]', ['section' => 'Index'], 'do_action'],
    ['GET', '/admin/[a:module]/[a:action]/[a:id]', ['section' => 'Admin'], 'action_record_admin'],
    ['GET', '/admin/[a:module]/[a:action]/', ['section' => 'Admin'], 'action_admin'],
    ['POST', '/admin/[a:module]/[a:action]/[a:id]', ['section' => 'Admin'], 'do_action_record_admin'],
    ['POST', '/admin/[a:module]/[a:action]/', ['section' => 'Admin'], 'do_action_admin'],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
