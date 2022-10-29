<?php

declare(strict_types=1);

namespace SetCMS\Database\MainMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Table;
use SetCMS\Module\Post\PostConstants;
use SetCMS\Module\Page\PageConstants;
use SetCMS\Module\User\UserContstants;

final class Version20220430204715 extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Create default tables';
    }

    public function up(Schema $schema): void
    {
        $posts = $schema->createTable(PostConstants::TABLE_NAME);
        $posts->addColumn('slug', 'string')->setLength(255);
        $posts->addColumn('title', 'string')->setLength(255);
        $posts->addColumn('message', 'text');
        $posts->addColumn('user_id', Types::GUID)->setNotnull(false);

        $this->addDefaultColumns($posts);

        $users = $schema->createTable(UserContstants::TABLE_NAME);
        $users->addColumn('username', 'string')->setLength(30);
        $users->addColumn('password', 'string')->setLength(255);
        $users->addColumn('role', 'string')->setLength(50);

        $this->addDefaultColumns($users);

        $pages = $schema->createTable(PageConstants::TABLE_NAME);
        $pages->addColumn('slug', 'string')->setLength(255);
        $pages->addColumn('title', 'string')->setLength(255);
        $pages->addColumn('content', 'text');

        $this->addDefaultColumns($pages);

        $oauthClients = $schema->createTable('oauth_clients');
        $oauthClients->addColumn('name', 'string')->setLength(255);
        $oauthClients->addColumn('client_id', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('client_secret', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('redirect_uri', 'string')->setLength(255)->setNotnull(false);
        $oauthClients->addColumn('is_authorizable', 'integer')->setLength(1)->setDefault(0);
        $oauthClients->addColumn('login_url', 'string')->setLength(255)->setNotnull(false);

        $this->addDefaultColumns($oauthClients);

        $oauthTokens = $schema->createTable('oauth_tokens');
        $oauthTokens->addColumn('token', 'string')->setLength(255);
        $oauthTokens->addColumn('refresh_token', 'string')->setLength(255);
        $oauthTokens->addColumn('client_id', 'string')->setLength(36);
        $oauthTokens->addColumn('user_id', Types::GUID);
        $oauthTokens->addColumn('date_expired', 'datetime')->setNotnull(true);

        $this->addDefaultColumns($oauthTokens);

        $oauthCodes = $schema->createTable('oauth_codes');
        $oauthCodes->addColumn('code', 'string')->setLength(255);
        $oauthCodes->addColumn('client_id', 'string')->setLength(36);
        $oauthCodes->addColumn('user_id', Types::GUID);

        $this->addDefaultColumns($oauthCodes);

        $oauthUsers = $schema->createTable('oauth_users');
        $oauthUsers->addColumn('client_id', 'string')->setLength(36);
        $oauthUsers->addColumn('user_id', Types::GUID);
        $oauthUsers->addColumn('external_id', 'text');
        $oauthUsers->addColumn('refresh_token', 'string')->setLength(255);

        $this->addDefaultColumns($oauthUsers);

        $captcha = $schema->createTable('captcha');
        $captcha->addColumn('is_used', 'integer')->setLength(1);
        $captcha->addColumn('is_solved', 'integer')->setLength(1);
        $captcha->addColumn('text', 'string')->setLength(50);
        $captcha->addColumn('solve_attempts', 'integer')->setLength(2);
        $captcha->addColumn('date_expiried', 'datetime');

        $this->addDefaultColumns($captcha);
    }

    private function addDefaultColumns(Table $table)
    {
        $table->addColumn('id', Types::GUID);
        $table->addColumn('entity_type', Types::STRING);
        $table->addColumn('date_created', Types::DATETIME_MUTABLE);
        $table->addColumn('date_modified', Types::DATETIME_MUTABLE);
        $table->addColumn('deleted', Types::BOOLEAN);
        $table->addUniqueIndex(['id']);
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('posts');
    }

}
