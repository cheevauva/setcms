<?php

declare(strict_types=1);

$themes = [];

foreach (glob(__DIR__ . '/themes/*') ?: [] as $file) {
    require $file;
}

return $themes;
