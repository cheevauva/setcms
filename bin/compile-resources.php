<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

$rootPath = \SetCMS\Bootstrap::instance()->rootPath();
$paths = [
    'resources/resources.php' => 'cache/resources.php',
    'resources/themes.php' => 'cache/themes.php',
    'resources/module/menu/adminMenu.php' => 'cache/module/menu/adminMenu.php',
];

foreach ($paths as $from => $to) {
    if (!is_dir(dirname($to))) {
        mkdir(dirname($to), 0777, true);
    }

    file_put_contents($rootPath . $to, sprintf('<?php return %s;', var_export(require $rootPath . $from, true)));
}

