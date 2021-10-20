<?php

namespace SetCMS\Database\Migration;

use SetCMS\Module\Users\UserDAO;
use SetCMS\Module\Users\User;
use SetCMS\Database\ConnectionFactory;
use Doctrine\DBAL\Schema\Table;

class Migration1633807971 extends \SetCMS\Database\Migration
{

    private UserDAO $userDAO;

    public function __construct(ConnectionFactory $connectionFactory, UserDAO $userDAO)
    {
        parent::__construct($connectionFactory);

        $this->userDAO = $userDAO;
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
        $table->addColumn('password', 'string')->setLength(30);
        $table->addColumn('is_admin', 'boolean');
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);
        
        $schemaManager->createTable($table);

        $user = new User;
        $user->username = 'admin';
        $user->password(User::hashPassword('administrator'));
        $user->isAdmin = true;

        $this->userDAO->save($user);
    }

}
