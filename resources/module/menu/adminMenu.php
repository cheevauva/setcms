<?php

declare(strict_types=1);

$adminMenu = [];

foreach (glob(__DIR__ . '/adminMenu/*') ?: [] as $file) {
    require $file;
}

ksort($adminMenu);

return $adminMenu;
