<?php

declare(strict_types=1);

use SetCMS\Database\MainConnection;

define('ROOT_PATH', dirname(__DIR__));

while (true) {
    if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
        break;
    } else {
        sleep(1);
    }
}

require_once ROOT_PATH . '/bootstrap.php';

$namespace = 'SetCMS\Database\MainMigration';
$directory = ROOT_PATH . '/src/SetCMS/Database/MainMigration';
$connection = $container->get(MainConnection::class);

require __DIR__ . '/migrations.php';
