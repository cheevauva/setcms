<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\CronSchedulerWork\CronSchedulerWorkConstrants;

final class Migration20250629124815Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return 'Таблица для модуля';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(CronSchedulerWorkConstrants::TABLE_NAME);
        $table->addColumn('status', Types::STRING)->setLength(255);

        $this->addDefaultColumns($table);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(CronSchedulerWorkConstrants::TABLE_NAME);
    }
}
