<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;
use SetCMS\Module\Post\PostConstrants;
use SetCMS\Module\Page\PageConstrants;
use SetCMS\Module\User\UserContstants;
use SetCMS\Module\UserSession\UserSessionConstrants;

final class Migration20220430204715Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

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
        $users->addColumn('email', 'string')->setLength(254);
        $users->addColumn('username', 'string')->setLength(30);
        $users->addColumn('password', 'string')->setLength(255);
        $users->addColumn('role', 'string')->setLength(50);
        $users->addColumn('extra', Types::JSON)->setDefault('{}');

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

        $sessions = $schema->createTable(UserSessionConstrants::TABLE_NAME);
        $sessions->addColumn('device', 'string')->setLength(50);
        $sessions->addColumn('user_id', Types::GUID)->setNotnull(false);
        $sessions->addColumn('date_expiries', 'datetime');

        $this->addDefaultColumns($sessions);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('posts');
    }
}
