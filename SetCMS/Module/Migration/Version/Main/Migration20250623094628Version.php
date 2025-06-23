<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\Template\TemplateConstrants;

final class Migration20250623094628Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return 'Таблица для модуля';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable(TemplateConstrants::TABLE_NAME);
        $table->addColumn('slug', Types::STRING)->setLength(50);
        $table->addColumn('title', Types::STRING)->setLength(255);
        $table->addColumn('template', Types::TEXT);
        $this->addDefaultColumns($table);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(TemplateConstrants::TABLE_NAME);
    }
}
