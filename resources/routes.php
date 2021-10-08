<?php

$routes = [
    ['GET', '/[a:module]/read/[a:id]', ['action' => 'read'], 'read'],
    ['GET', '/[a:module]/edit/[a:id]', ['action' => 'edit'], 'edit'],
    ['GET', '/admin/[a:module]/read/[a:id]', ['action' => 'read', 'section' => 'Admin'], 'admin_read'],
    ['GET', '/admin/[a:module]/edit/[a:id]', ['action' => 'edit', 'section' => 'Admin'], 'admin_edit'],
    ['GET', '/admin/[a:module]/create/', ['action' => 'create', 'section' => 'Admin'], 'admin_create'],
    ['GET', '/admin/[a:module]/index/', ['action' => 'index', 'section' => 'Admin'], 'admin_index'],
    ['GET', '/', ['action' => 'index', 'module' => 'Posts'], 'home'],
    ['GET', '/[a:module]/', ['action' => 'index'], 'index'],
    ['GET', '/[a:module]', ['action' => 'index'], 'index_alt'],
    ['GET', '/[a:module]/[a:action]', ['section' => 'Index']],
    ['GET', '/admin/[a:module]/[a:action]', ['section' => 'Admin']],
//    ['POST', '/[a:module]/[a:action]/[i:id]', []],
    ['POST', '/[a:module]/save', ['action' => 'save'], 'save'],
    ['POST', '/admin/[a:module]/save', ['action' => 'save', 'section' => 'Admin'], 'admin_save'],
];

foreach (glob(__DIR__ . '/routes/*') as $file) {
    require $file;
}

return $routes;
