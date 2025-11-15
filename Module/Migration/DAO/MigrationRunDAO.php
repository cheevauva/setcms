<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

use SetCMS\Database\Database;

class MigrationRunDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    public Database $db;
    public string $sql;

    #[\Override]
    public function serve(): void
    {
        $this->db->executeQuery($this->sql);
    }
}
