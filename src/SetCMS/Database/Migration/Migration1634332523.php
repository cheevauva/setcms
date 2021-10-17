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

    private function createOAuthClientsTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_clients')) {
            return;
        }

        $table = new Table('oauth_clients');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('name', 'string')->setLength(255);
        $table->addColumn('client_id', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('client_secret', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('redirect_uri', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('login_url', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);
    }

    private function createOAuthTokensTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_tokens')) {
            return;
        }

        $table = new Table('oauth_tokens');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('token', 'string')->setLength(255);
        $table->addColumn('refresh_token', 'string')->setLength(255);
        $table->addColumn('client_id', 'integer')->setNotnull(true);
        $table->addColumn('user_id', 'integer')->setNotnull(true);
        $table->addColumn('date_expired', 'datetime')->setNotnull(true);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);
    }

    private function createOAuthCodesTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_codes')) {
            return;
        }

        $table = new Table('oauth_codes');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('code', 'string')->setLength(255);
        $table->addColumn('client_id', 'integer')->setNotnull(true);
        $table->addColumn('user_id', 'integer')->setNotnull(true);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);
    }

    public function up(): void
    {
        $this->createOAuthClientsTable();
        $this->createOAuthTokensTable();
        $this->createOAuthCodesTable();

        $client = new OAuthClient;
        $client->name = 'SetCMS';
        $client->clientId = 1;
        $client->clientSecret = OAuthClient::generateSecret();
        $client->loginURL = 'index.php/Users/login?test=1';
        $client->redirectURI = 'index.php/OAuth/code';

        $this->oauthClientDAO->save($client);
    }

}
