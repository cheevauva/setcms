<?php

namespace SetCMS\Module\Posts;

use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDO\SQLite\Driver;
use Psr\Container\ContainerInterface;

class PostDatabase extends Connection
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct([
            'path' => $container->get('basePath') . '/cache/posts.db',
            'driver' => 'pdo_sqlite',
            'charset' => 'UTF8',
        ], new Driver);

        $this->createTable();
    }

    protected function createTable(): void
    {
        $schemaManager = $this->createSchemaManager();

        if ($schemaManager->tablesExist('posts')) {
            return;
        }

        $table = new Table('posts');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('slug', 'string')->setLength(255);
        $table->addColumn('title', 'string')->setLength(255);
        $table->addColumn('message', 'text');
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');


        $schemaManager->createTable($table);
    }

}
