<?php

require_once __DIR__ . '/vendor/autoload.php';

use SetCMS\Bootstrap;

$container = Bootstrap::instance()->newContainer();

return $container;
