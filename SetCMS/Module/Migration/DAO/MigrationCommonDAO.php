<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\DAO;

use SetCMS\Module\Migration\Mapper\MigrationMapper;
use SetCMS\Module\Migration\MigrationConstants;
use SetCMS\Database\Database;

trait MigrationCommonDAO
{

    use \UUA\Traits\ContainerTrait;

    public Database $db;

    #[\Override]
    protected function db(): Database
    {
        return $this->db;
    }

    protected function mapper(): MigrationMapper
    {
        return MigrationMapper::new($this->container);
    }

    protected function table(): string
    {
        return MigrationConstants::TABLE_NAME;
    }
}
