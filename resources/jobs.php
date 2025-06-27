<?php

declare(strict_types=1);

foreach (glob(__DIR__ . '/jobs/*') as $file) {
    require $file;
}