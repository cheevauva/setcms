<?php

declare(strict_types=1);

use SetCMS\Application\Database\DatabaseMainConnection;
use SetCMS\Module\Migration\Version\Main\Migration20220430204715Version;

define('ROOT_PATH', dirname(__DIR__));

while (true) {
    if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
        break;
    } else {
        sleep(1);
    }
}

require_once ROOT_PATH . '/bootstrap.php';
$namespace = (new \ReflectionClass(Migration20220430204715Version::class))->getNamespaceName();
$directory = dirname((new \ReflectionClass(Migration20220430204715Version::class))->getFileName());
$connection = $container->get(DatabaseMainConnection::class);

require __DIR__ . '/migrations.php';
