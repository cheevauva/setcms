<?php

namespace SetCMS\Module\Users;

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDO\SQLite\Driver;

class UserDatabase extends Connection
{

    public function __construct()
    {
        parent::__construct([
            'path' => 'cache/users.db',
            'driver' => 'pdo_sqlite',
            'charset' => 'UTF8',
        ], new Driver);

        $this->createTable();
    }

    protected function createTable(): void
    {
        $schemaManager = $this->createSchemaManager();

        if ($schemaManager->tablesExist('users')) {
            return;
        }

        $table = new Table('users');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('username', 'string')->setLength(30);
        $table->addColumn('password', 'string')->setLength(30);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        
        $schemaManager->createTable($table);
    }

}
