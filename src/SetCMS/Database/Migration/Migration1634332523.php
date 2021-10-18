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
        $table->addColumn('id', 'integer')->setAutoincrement(true);
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

    private function createOAuthUsersTable(): void
    {
        $schemaManager = $this->dbal()->createSchemaManager();

        if ($schemaManager->tablesExist('oauth_users')) {
            return;
        }

        $table = new Table('oauth_users');
        $table->addColumn('id', 'integer')->setAutoincrement(true);
        $table->addColumn('client_id', 'integer')->setNotnull(true);
        $table->addColumn('user_id', 'integer')->setNotnull(true);
        $table->addColumn('external_id', 'text');
        $table->addColumn('refresh_token', 'string')->setLength(255);
        $table->addColumn('date_created', 'datetime');
        $table->addColumn('date_modified', 'datetime');

        $schemaManager->createTable($table);
    }

    protected function addClientSetCMS($baseUrl)
    {
        $client = new OAuthClient;
        $client->name = 'SetCMS';
        $client->clientId = 1;
        $client->isAuthorizable = true;
        $client->clientSecret = OAuthClient::generateSecret();
        $client->redirectURI = $baseUrl . '/OAuth/callback/1';
        $client->loginUrl = $baseUrl . '/OAuth/authorize';
        $client->autorizationCodeUrl = $baseUrl . '/OAuth/token';
        $client->userInfoUrl = $baseUrl . '/Users/userinfo';
        $client->userInfoParserRule = implode("\n", [
            'externalId' => 'id',
        ]);

        $this->oauthClientDAO->save($client);
    }

    protected function addClientGoogle($baseUrl)
    {
        $client = new OAuthClient;
        $client->name = 'Google';
        $client->clientId = 'нужно_заменить';
        $client->isAuthorizable = false;
        $client->clientSecret = 'нужно_заменить';
        $client->redirectURI = $baseUrl . '/OAuth/callback/2';
        $client->loginUrl = 'https://accounts.google.com/o/oauth2/v2/auth?scope=openid email profile&access_type=offline&include_granted_scopes=true';
        $client->autorizationCodeUrl = 'https://oauth2.googleapis.com/token';
        $client->userInfoUrl = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json';
        $client->userInfoParserRule = implode("\n", [
            'externalId' => 'id',
        ]);

        $this->oauthClientDAO->save($client);
    }

    protected function addOAuthUserSetCMS()
    {
        $oauthUser = new OAuthUser;
        $oauthUser->clientId = 1;
        $oauthUser->externalId = 1;
        $oauthUser->refreshToken = '';
        $oauthUser->userId = 1;

        $this->oauthUserDAO->save($oauthUser);
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

        $this->addClientSetCMS($baseUrl);
        $this->addClientGoogle($baseUrl);
        $this->addOAuthUserSetCMS();
    }

}
