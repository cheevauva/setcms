<?php

declare(strict_types=1);

$exceptionHandlers = [];

foreach (glob(__DIR__ . '/exceptionHandlers/*') ?: [] as $file) {
    require $file;
}

return $exceptionHandlers;
