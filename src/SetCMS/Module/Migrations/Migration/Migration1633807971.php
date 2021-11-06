<?php

namespace SetCMS\Module\Migrations\Migration;

use SetCMS\Module\Users\UserDAO;
use SetCMS\Database\ConnectionFactory;
use SetCMS\Module\Users\UserService;
use Doctrine\DBAL\Schema\Table;

class Migration1633807971 implements MigrationInterface
{

    use MigrationDBALTrait;

    private UserService $userService;

    public function __construct(ConnectionFactory $connectionFactory, UserService $userService)
    {
        $this->connectionFactory = $connectionFactory;
        $this->userService = $userService;
    }

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(UserDAO::class);
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('users')) {
            return;
        }

        $table = new Table('users');
        $table->addColumn('username', 'string')->setLength(30);
        $table->addColumn('password', 'string')->setLength(255);
        $table->addColumn('role', 'string')->setLength(50);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);

        $this->userService->getGuestUser();
        $this->userService->getMainAdminUser();
    }

    public function down(): void
    {
        $this->dbal()->createSchemaManager()->dropTable('users');
    }

}
