<?php

namespace SetCMS\Module\Posts;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Module\Posts\PostDAO;

class Migration1 extends \SetCMS\Database\Migration
{

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

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

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(PostDAO::class);
    }

}
