<?php

namespace SetCMS\Module\Migrations\Migration;

use SetCMS\Module\Blocks\BlockDAO;
use Doctrine\DBAL\Schema\Table;

class Migration1636277685 implements MigrationInterface
{

    use MigrationDBALTrait;

    public function down(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager()->dropTable('blocks');
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('blocks')) {
            return;
        }

        $table = new Table('blocks');
        $table->addColumn('name', 'string')->setLength(255);
        $table->addColumn('block', 'string')->setLength(50);
        $table->addColumn('side', 'string')->setLength(50);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

    protected function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(BlockDAO::class);
    }

}
