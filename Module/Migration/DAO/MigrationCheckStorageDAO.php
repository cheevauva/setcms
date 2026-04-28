<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

class MigrationCheckStorageDAO extends \UUA\DAO
{

    use \Module\Migration\Traits\MigrationDbalDAOTrait;

    public protected(set) bool $isOk;

    #[\Override]
    public function serve(): void
    {
        $this->isOk = $this->db()->createSchemaManager()->tableExists($this->table());
    }
}
