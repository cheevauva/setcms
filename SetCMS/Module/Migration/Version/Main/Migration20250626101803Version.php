<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\CronScheduler\CronSchedulerConstrants;

final class Migration20250626101803Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    #[\Override]
    public function getDescription(): string
    {
        return 'Таблица для модуля CronScheduler';
    }

    #[\Override]
    public function up(Schema $schema): void
    {
        $table = $schema->createTable(CronSchedulerConstrants::TABLE_NAME);
        $table->addColumn('job', Types::STRING)->setLength(255)->setNotnull(true);
        $table->addColumn('cron_expression', Types::STRING)->setLength(255)->setNotnull(true);
        $table->addColumn('is_active', Types::BOOLEAN)->setDefault(1);
        $table->addColumn('is_safe_run', Types::BOOLEAN)->setDefault(1);
        $table->addColumn('date_start', Types::DATETIME_MUTABLE)->setNotnull(false);
        $table->addColumn('date_end', Types::DATETIME_MUTABLE)->setNotnull(false);

        $this->addDefaultColumns($table);
    }

    #[\Override]
    public function down(Schema $schema): void
    {
        $schema->dropTable(CronSchedulerConstrants::TABLE_NAME);
    }
}
