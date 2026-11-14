<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

use Module\Migration\Mapper\MigraionFromRowMapper;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\Migration\Entity\MigrationEntity;

/**
 * @extends EntityRetrieveByCriteriaDAO<MigrationEntity>
 */
class MigrationRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\Migration\Traits\MigrationDbalDAOTrait;

    #[\Override]
    protected function rowToEntity(array $row): MigrationEntity
    {
        return MigraionFromRowMapper::call($this, $row)->entity;
    }
}
