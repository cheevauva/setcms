<?php

declare(strict_types=1);

namespace SetCMS\Database\MainMigration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Table;
use SetCMS\Module\Post\PostConstrants;
use SetCMS\Module\Page\PageConstrants;
use SetCMS\Module\User\UserContstants;
use SetCMS\Module\Session\SessionConstrants;

final class Version20220430204715 extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Create default tables';
    }

    public function up(Schema $schema): void
    {
        $posts = $schema->createTable(PostConstrants::TABLE_NAME);
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

        $pages = $schema->createTable(PageConstrants::TABLE_NAME);
        $pages->addColumn('slug', 'string')->setLength(255);
        $pages->addColumn('title', 'string')->setLength(255);
        $pages->addColumn('content', 'text');

        $this->addDefaultColumns($pages);

        $captcha = $schema->createTable('captcha');
        $captcha->addColumn('is_used', 'integer')->setLength(1);
        $captcha->addColumn('is_solved', 'integer')->setLength(1);
        $captcha->addColumn('text', 'string')->setLength(50);
        $captcha->addColumn('solve_attempts', 'integer')->setLength(2);
        $captcha->addColumn('date_expiried', 'datetime');

        $this->addDefaultColumns($captcha);

        $sessions = $schema->createTable(SessionConstrants::TABLE_NAME);
        $sessions->addColumn('device', 'string')->setLength(50);
        $sessions->addColumn('user_id', Types::GUID)->setNotnull(false);
        $sessions->addColumn('date_expiries', 'datetime');

        $this->addDefaultColumns($sessions);
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
