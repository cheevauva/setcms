<?php

namespace SetCMS\Database\Migration;

use SetCMS\Database\Migration;
use SetCMS\Module\Migrations\MigrationDAO;
use Doctrine\DBAL\Schema\Table;

class Migration1633807613 extends Migration
{

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(MigrationDAO::class);
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('migrations')) {
            return;
        }

        $table = new Table('migrations');
        $table->addColumn('migration', 'string')->setLength(255);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

}
