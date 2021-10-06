<?php

return [
    ['GET', '/[a:module]/read/[a:id]', ['action' => 'read'], 'read'],
    ['GET', '/[a:module]/edit/[a:id]', ['action' => 'edit'], 'edit'],
    ['GET', '/admin/[a:module]/read/[a:id]', ['action' => 'read', 'section' => 'Admin'], 'admin_read'],
    ['GET', '/admin/[a:module]/edit/[a:id]', ['action' => 'edit', 'section' => 'Admin'], 'admin_edit'],
    ['GET', '/', ['action' => 'index', 'module' => 'Posts'], 'home'],
    ['GET', '/[a:module]/', ['action' => 'index'], 'index'],
    ['GET', '/[a:module]', ['action' => 'index'], 'index_alt'],
//    ['GET', '/[a:module]/[a:action]', []],
//    ['POST', '/[a:module]/[a:action]/[i:id]', []],
    ['POST', '/[a:module]/save', ['action' => 'save'], 'save'],
    ['POST', '/admin/[a:module]/save', ['action' => 'save', 'section' => 'Admin'], 'admin_save'],
];
