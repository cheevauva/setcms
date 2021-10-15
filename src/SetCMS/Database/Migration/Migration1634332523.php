<?php

namespace SetCMS\Database\Migration;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Database\ConnectionFactory;
use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthClient;

class Migration1634332523 extends \SetCMS\Database\Migration
{

    private OAuthClientDAO $oauthClientDAO;

    public function __construct(ConnectionFactory $connectionFactory, OAuthClientDAO $oauthClientDAO)
    {
        parent::__construct($connectionFactory);

        $this->oauthClientDAO = $oauthClientDAO;
    }

    public function dbal(): \Doctrine\DBAL\Connection
    {
        return $this->connectionFactory->get(OAuthClientDAO::class);
    }

    public function up(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_clients')) {
            return;
        }

        $table = new Table('oauth_clients');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('name', 'string')->setLength(255);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);

        $client = new OAuthClient;
        $client->name = 'SetCMS';

        $this->oauthClientDAO->save($client);
    }

}
