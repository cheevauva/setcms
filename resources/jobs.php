<?php

declare(strict_types=1);

$jobs = [];

foreach (glob(__DIR__ . '/jobs/*') as $file) {
    require $file;
}

return $jobs;
