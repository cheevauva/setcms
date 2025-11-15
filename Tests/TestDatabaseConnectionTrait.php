<?php

declare(strict_types=1);

namespace Tests;

use SetCMS\Database\DatabaseDriverManager;
use SetCMS\Database\Database;

trait TestDatabaseConnectionTrait
{

    protected function db(): Database
    {
        return DatabaseDriverManager::getConnection([
            'wrapperClass' => Database::class,
            'driver' => 'pdo_sqlite',
            'charset' => 'UTF8',
            'dsn' => 'sqlite::memory:?cache=shared',
        ]);
    }
}
