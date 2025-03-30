<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use SetCMS\Module\Block\BlockConstrants;
use Doctrine\DBAL\Types\Types;

final class Migration20230312144813Version extends AbstractMigration
{

    use \SetCMS\Module\Migration\Traits\MigrationVersionTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $blocks = $schema->createTable(BlockConstrants::TABLE_NAME);
        $blocks->addColumn('path', Types::TEXT);
        $blocks->addColumn('params', Types::JSON);
        $blocks->addColumn('template', Types::TEXT);
        $blocks->addColumn('section', Types::STRING)->setLength(255);

        $this->addDefaultColumns($blocks);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(BlockConstrants::TABLE_NAME);
    }
}
