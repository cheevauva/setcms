<?php

declare(strict_types=1);

namespace Module\Migration\DAO;

use Module\Migration\Mapper\MigraionFromRowMapper;
use Module\Migration\Exception\MigrationNotFoundException;
use Module\Migration\Entity\MigrationEntity;

class MigrationRetrieveManyByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use \Module\Migration\Traits\MigrationDbalDAOTrait;

    /**
     * @var array<MigrationEntity>
     */
    public array $migrations;
    public MigrationEntity $migration;
    public ?MigrationEntity $migrationOrNull = null;

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new MigrationNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new MigrationNotFoundException();
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new MigrationNotFoundException();
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->migrations = array_map(fn($row) => MigraionFromRowMapper::call($this->container, $row)->migration, $rows);
        $this->migrations ? $this->migration = $this->migrationOrNull = $this->migrations[0] : null;
    }
}
