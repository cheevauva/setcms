<?php

declare(strict_types=1);

$menuActions = [];

foreach (glob(__DIR__ . '/menuActions/*') ?: [] as $file) {
    require $file;
}

ksort($menuActions);

return $menuActions;
