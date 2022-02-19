<?php

namespace SetCMS\Module\Migrations\Migration;

use Doctrine\DBAL\Schema\Table;

class Migration1638999986 implements MigrationInterface
{

    //put your code here
    public function down(): void
    {
        
    }

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(CaptchaDAO::class);
    }

    public function up(): void
    {
        return;
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('config')) {
            return;
        }

        $table = new Table('config');
        $table->addColumn('name', 'string')->setLength(255);
        $table->addColumn('value', 'text');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

}
