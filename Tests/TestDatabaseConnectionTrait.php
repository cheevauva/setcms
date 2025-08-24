<?php

declare(strict_types=1);

namespace SetCMS\Tests;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Connection;

trait TestDatabaseConnectionTrait
{

    protected function db(): Connection
    {
        return DriverManager::getConnection([
            'driver' => 'pdo_sqlite',
            'charset' => 'UTF8',
            'dsn' => 'sqlite::memory:?cache=shared',
        ]);
    }
}
