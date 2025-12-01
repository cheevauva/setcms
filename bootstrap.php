<?php

require_once __DIR__ . '/vendor/autoload.php';

use SetCMS\Bootstrap;

$container = Bootstrap::instance()->newContainer();

define('ADMIN_USER_UUID', $container->get('env')['ADMIN_USER_UUID'] ?? 'c5e35038-4d12-4d90-be57-f4eb1a45fe35');

return $container;
