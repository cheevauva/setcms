<?php

declare(strict_types=1);

namespace SetCMS\Database\MainMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220430204715 extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Create default tables';
    }

    public function up(Schema $schema): void
    {
        $posts = $schema->createTable('posts');
        $posts->addColumn('slug', 'string')->setLength(255);
        $posts->addColumn('title', 'string')->setLength(255);
        $posts->addColumn('message', 'text');
        $posts->addColumn('date_created', 'datetime');
        $posts->addColumn('date_modified', 'datetime');
        $posts->addColumn('date_modified', 'datetime');
        $posts->addColumn('id', 'string')->setLength(36);
        $posts->addColumn('user_id', 'string')->setLength(36)->setNotnull(true)->setDefault(1);
        $posts->addUniqueIndex(['id']);
        $posts->setPrimaryKey(['id']);

        $users = $schema->createTable('users');
        $users->addColumn('username', 'string')->setLength(30);
        $users->addColumn('password', 'string')->setLength(255);
        $users->addColumn('role', 'string')->setLength(50);
        $users->addColumn('date_created', 'datetime');
        $users->addColumn('date_modified', 'datetime');
        $users->addColumn('id', 'string')->setLength(36);
        $users->addUniqueIndex(['id']);
        $users->setPrimaryKey(['id']);

        $pages = $schema->createTable('pages');
        $pages->addColumn('slug', 'string')->setLength(255);
        $pages->addColumn('title', 'string')->setLength(255);
        $pages->addColumn('content', 'text');
        $pages->addColumn('date_created', 'datetime');
        $pages->addColumn('date_modified', 'datetime');
        $pages->addColumn('id', 'string')->setLength(36);
        $pages->addUniqueIndex(['id']);
        $pages->setPrimaryKey(['id']);

        $oauthClients = $schema->createTable('oauth_clients');
        $oauthClients->addColumn('name', 'string')->setLength(255);
        $oauthClients->addColumn('client_id', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('client_secret', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('redirect_uri', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('is_authorizable', 'integer')->setLength(1)->setDefault(0);
        $oauthClients->addColumn('login_url', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('autorization_code_url', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('userinfo_url', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('userinfo_parser_rule', 'text')->setNotnull(false);
        $oauthClients->addColumn('date_created', 'datetime');
        $oauthClients->addColumn('date_modified', 'datetime');
        $oauthClients->addColumn('id', 'string')->setLength(36);
        $oauthClients->addUniqueIndex(['id']);
        $oauthClients->setPrimaryKey(['id']);

        $oauthTokens = $schema->createTable('oauth_tokens');
        $oauthTokens->addColumn('token', 'string')->setLength(255);
        $oauthTokens->addColumn('refresh_token', 'string')->setLength(255);
        $oauthTokens->addColumn('client_id', 'string')->setLength(36);
        $oauthTokens->addColumn('user_id', 'string')->setLength(36);
        $oauthTokens->addColumn('date_expired', 'datetime')->setNotnull(true);
        $oauthTokens->addColumn('date_created', 'datetime');
        $oauthTokens->addColumn('date_modified', 'datetime');
        $oauthTokens->addColumn('id', 'string')->setLength(36);
        $oauthTokens->addUniqueIndex(['id']);
        $oauthTokens->setPrimaryKey(['id']);

        $oauthCodes = $schema->createTable('oauth_codes');
        $oauthCodes->addColumn('code', 'string')->setLength(255);
        $oauthCodes->addColumn('client_id', 'integer')->setLength(36);
        $oauthCodes->addColumn('user_id', 'integer')->setLength(36);
        $oauthCodes->addColumn('date_created', 'datetime');
        $oauthCodes->addColumn('date_modified', 'datetime');
        $oauthCodes->addColumn('id', 'string')->setLength(36);
        $oauthCodes->addUniqueIndex(['id']);
        $oauthCodes->setPrimaryKey(['id']);

        $oauthUsers = $schema->createTable('oauth_users');
        $oauthUsers->addColumn('client_id', 'integer')->setLength(36);
        $oauthUsers->addColumn('user_id', 'integer')->setLength(36);
        $oauthUsers->addColumn('external_id', 'text');
        $oauthUsers->addColumn('refresh_token', 'string')->setLength(255);
        $oauthUsers->addColumn('date_created', 'datetime');
        $oauthUsers->addColumn('date_modified', 'datetime');
        $oauthUsers->addColumn('id', 'string')->setLength(36);
        $oauthUsers->addUniqueIndex(['id']);
        $oauthUsers->setPrimaryKey(['id']);

        $captcha = $schema->createTable('captcha');
        $captcha->addColumn('is_used', 'integer')->setLength(1);
        $captcha->addColumn('is_solved', 'integer')->setLength(1);
        $captcha->addColumn('text', 'string')->setLength(50);
        $captcha->addColumn('solve_attempts', 'integer')->setLength(2);
        $captcha->addColumn('date_expiried', 'datetime');
        $captcha->addColumn('date_created', 'datetime');
        $captcha->addColumn('date_modified', 'datetime');
        $captcha->addColumn('id', 'string')->setLength(36);
        $captcha->addUniqueIndex(['id']);
        $captcha->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('posts');
    }

}
