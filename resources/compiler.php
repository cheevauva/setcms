<?php

declare(strict_types=1);

$compiler = [];

foreach (glob(__DIR__ . '/compliler/*') ?: [] as $file) {
    require $file;
}

ksort($compiler);

return $compiler;
