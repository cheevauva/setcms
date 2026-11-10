<?php

declare(strict_types=1);

$wrappers = [];

foreach (glob(__DIR__ . '/wrappers/*.php') ?: [] as $file) {
    require $file;
}

return $wrappers;
