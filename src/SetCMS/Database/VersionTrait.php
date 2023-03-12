<?php

declare(strict_types=1);

namespace SetCMS\Database;

use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Table;

trait VersionTrait
{

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

}
