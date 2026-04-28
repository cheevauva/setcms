<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

use Module\Migration\Mapper\MigraionToRowMapper;
use Module\Migration\Entity\MigrationEntity;

class MigrationCreateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityCreateTrait;
    use \Module\Migration\Traits\MigrationDbalDAOTrait;
    
    public MigrationEntity $migration;

    #[\Override]
    protected function row(): array
    {
        return MigraionToRowMapper::call($this->container, $this->migration)->row;
    }
}
