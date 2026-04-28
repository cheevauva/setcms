<?php

declare(strict_types=1);

namespace Module\Migration\Traits;

use SetCMS\Database\Database;
use Module\Migration\MigrationConstants;

trait MigrationDbalDAOTrait
{

    public Database $db;

    protected function db(): Database
    {
        return $this->db;
    }

    protected function table(): string
    {
        return MigrationConstants::TABLE_NAME;
    }
}
