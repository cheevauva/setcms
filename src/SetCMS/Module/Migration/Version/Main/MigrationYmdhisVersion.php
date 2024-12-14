<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\Module01\Module01Constrants;

final class MigrationYmdhisVersion extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return 'Таблица для модуля';
    }

    public function up(Schema $schema): void
    {
        $menu = $schema->createTable(Module01Constrants::TABLE_NAME);
        $menu->addColumn('field01', Types::STRING)->setLength(255);

        $this->addDefaultColumns($menu);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Module01Constrants::TABLE_NAME);
    }
}
