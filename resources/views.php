<?php

declare(strict_types=1);

$routes = [];

foreach (glob(__DIR__ . '/views/*') as $file) {
    require $file;
}

return $routes;
