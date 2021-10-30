<?php

namespace SetCMS\Database\Migration;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Database\ConnectionFactory;
use SetCMS\Module\Captcha\CaptchaDAO;

class Migration1635616296 extends \SetCMS\Database\Migration
{

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(CaptchaDAO::class);
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('captcha')) {
            return;
        }

        $table = new Table('captcha');
        $table->addColumn('is_used', 'integer')->setLength(1);
        $table->addColumn('is_solved', 'integer')->setLength(1);
        $table->addColumn('text', 'string')->setLength(50);
        $table->addColumn('solve_attempts', 'integer')->setLength(2);
        $table->addColumn('date_expiried', 'datetime');
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

}
