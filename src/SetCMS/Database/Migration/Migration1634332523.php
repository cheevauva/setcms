<?php

namespace SetCMS\Database\Migration;

use Doctrine\DBAL\Schema\Table;
use SetCMS\Database\ConnectionFactory;
use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\OAuth\OAuthUserDAO;
use SetCMS\Module\OAuth\OAuthUser;

class Migration1634332523 extends \SetCMS\Database\Migration
{

    private OAuthClientDAO $oauthClientDAO;
    private OAuthUserDAO $oauthUserDAO;

    public function __construct(ConnectionFactory $connectionFactory, OAuthClientDAO $oauthClientDAO, OAuthUserDAO $oauthUserDAO)
    {
        parent::__construct($connectionFactory);

        $this->oauthClientDAO = $oauthClientDAO;
        $this->oauthUserDAO = $oauthUserDAO;
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
        $table->addColumn('name', 'string')->setLength(255);
        $table->addColumn('client_id', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('client_secret', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('redirect_uri', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('is_authorizable', 'integer')->setLength(1)->setDefault(0);
        $table->addColumn('login_url', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('autorization_code_url', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('userinfo_url', 'string')->setLength(255)->setNotnull(false);
        $table->addColumn('userinfo_parser_rule', 'text')->setNotnull(false);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

    private function createOAuthTokensTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_tokens')) {
            return;
        }

        $table = new Table('oauth_tokens');
        $table->addColumn('token', 'string')->setLength(255);
        $table->addColumn('refresh_token', 'string')->setLength(255);
        $table->addColumn('client_id', 'string')->setLength(36);
        $table->addColumn('user_id', 'string')->setLength(36);
        $table->addColumn('date_expired', 'datetime')->setNotnull(true);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

    private function createOAuthCodesTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_codes')) {
            return;
        }

        $table = new Table('oauth_codes');
        $table->addColumn('code', 'string')->setLength(255);
        $table->addColumn('client_id', 'integer')->setLength(36);
        $table->addColumn('user_id', 'integer')->setLength(36);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

    private function createOAuthUsersTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_users')) {
            return;
        }

        $table = new Table('oauth_users');
        $table->addColumn('client_id', 'integer')->setLength(36);
        $table->addColumn('user_id', 'integer')->setLength(36);
        $table->addColumn('external_id', 'text');
        $table->addColumn('refresh_token', 'string')->setLength(255);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }

    protected function addClientSetCMS($baseUrl): OAuthClient
    {
        $client = new OAuthClient;
        $client->name = 'SetCMS';
        $client->clientId = $client->id;
        $client->isAuthorizable = true;
        $client->clientSecret = OAuthClient::generateSecret();
        $client->redirectURI = $baseUrl . '/OAuth/callback/' . $client->id;
        $client->loginUrl = $baseUrl . '/OAuth/authorize';
        $client->autorizationCodeUrl = $baseUrl . '/OAuth/token';
        $client->userInfoUrl = $baseUrl . '/Users/userinfo';
        $client->userInfoParserRule = 'id';

        $this->oauthClientDAO->save($client);

        return $client;
    }
    
    protected function getAnyAdminId(): string
    {
        $qb = $this->dbal()->createQueryBuilder();
        $qb->select('id');
        $qb->from('users');
        $qb->setMaxResults(1);
        $qb->andWhere('is_admin = 1');
        
        return $qb->fetchOne();
    }

    protected function addOAuthUserSetCMS(OAuthClient $client): OAuthUser
    {
        $oauthUser = new OAuthUser;
        $oauthUser->clientId = $client->id;
        $oauthUser->externalId = $this->getAnyAdminId();
        $oauthUser->refreshToken = '';
        $oauthUser->userId = $this->getAnyAdminId();

        $this->oauthUserDAO->save($oauthUser);

        return $oauthUser;
    }

    public function up(): void
    {
        $this->createOAuthClientsTable();
        $this->createOAuthTokensTable();
        $this->createOAuthCodesTable();
        $this->createOAuthUsersTable();

        if ($_SERVER) {
            $baseUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/index.php';
        } else {
            $baseUrl = 'http://localhost/index.php';
        }

        $oauthClient = $this->addClientSetCMS($baseUrl);
        $oauthUser = $this->addOAuthUserSetCMS($oauthClient);
    }

}
