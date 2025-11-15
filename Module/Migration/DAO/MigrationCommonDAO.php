<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

use Module\Migration\Mapper\MigrationMapper;
use Module\Migration\MigrationConstants;
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
