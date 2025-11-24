<?php

declare(strict_types=1);

$entities = [];

foreach (glob(__DIR__ . '/entities/*') ?: [] as $file) {
    require $file;
}

ksort($entities);

return $entities;
