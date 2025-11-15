<?php

declare(strict_types=1);

$middlewares = [];

foreach (glob(__DIR__ . '/middlewares/*') ?: [] as $file) {
    require $file;
}

ksort($middlewares);

return $middlewares;
