<?php

return [
    ['GET', '/[a:module]/read/[*:id]', ['action' => 'read'], 'read'],
    ['GET', '/[a:module]/edit/[*:id]', ['action' => 'edit'], 'edit'],
    ['GET', '/', ['action' => 'index', 'module' => 'Posts'], 'index_post'],
    ['GET', '/[a:module]/', ['action' => 'index'], 'index'],
    ['GET', '/[a:module]/[a:action]', []],
    ['POST', '/[a:module]/[a:action]/[i:id]', []],
    ['POST', '/[a:module]/save', ['action' => 'save'], 'save'],
];
