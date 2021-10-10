<?php

namespace SetCMS\Database\Migration;

use SetCMS\Module\Pages\PageDAO;
use Doctrine\DBAL\Schema\Table;

class Migration1633869502 extends \SetCMS\Database\Migration
{

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(PageDAO::class);
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('pages')) {
            return;
        }

        $table = new Table('pages');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('slug', 'string')->setLength(255);
        $table->addColumn('title', 'string')->setLength(255);
        $table->addColumn('content', 'text');
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);
    }

}
