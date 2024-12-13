<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\Menu\MenuConstrants;

final class Migration20241213203912Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return 'Таблица для модуля меню';
    }

    public function up(Schema $schema): void
    {
        $menu = $schema->createTable(MenuConstrants::TABLE_NAME);
        $menu->addColumn('label', 'string')->setLength(255);
        $menu->addColumn('route', 'string')->setLength(255);
        $menu->addColumn('params', Types::JSON)->setNotnull(true);

        $this->addDefaultColumns($menu);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(MenuConstrants::TABLE_NAME);
    }
}
