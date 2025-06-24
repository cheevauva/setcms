<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\Email\EmailConstrants;

final class Migration20250624181512Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return 'Таблица для модуля электронных писем';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(EmailConstrants::TABLE_NAME);
        $table->addColumn('from_addr', Types::STRING)->setLength(255)->setNotnull(true);
        $table->addColumn('to_addr', Types::STRING)->setLength(255)->setNotnull(true);
        $table->addColumn('subject', Types::STRING)->setLength(255)->setNotnull(true);
        $table->addColumn('status', Types::STRING)->setLength(50)->setNotnull(true)->setDefault('new');
        $table->addColumn('date_sent', Types::DATETIME_MUTABLE)->setNotnull(false);
        $table->addColumn('body', Types::TEXT)->setNotnull(true);

        $this->addDefaultColumns($table);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(EmailConstrants::TABLE_NAME);
    }
}
