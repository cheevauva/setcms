<?php

declare(strict_types=1);

use SetCMS\Application\Database\DatabaseMainConnection;

define('ROOT_PATH', dirname(__DIR__));

while (true) {
    if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
        break;
    } else {
        sleep(1);
    }
}

require ROOT_PATH . '/bootstrap.php';

$directory = 'resources/migrations/sqlite/main';
$connection = DatabaseMainConnection::singleton($container)->getConnection();
$name = 'main';

require __DIR__ . '/migrations.php';
