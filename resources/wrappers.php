<?php

declare(strict_types=1);

$decorators = [];

foreach (glob(__DIR__ . '/decorators/*.php') ?: [] as $file) {
    require $file;
}

return $decorators;
