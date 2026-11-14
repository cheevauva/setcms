<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

use Module\Migration\Entity\MigrationEntity;
use SetCMS\Entity\Mapper\EntityFromRowMapper;

/**
 * @extends EntityFromRowMapper<MigrationEntity>
 */
class MigraionFromRowMapper extends EntityFromRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $migration = $this->entity = new MigrationEntity();
        $migration->version = $this->string('version');
        $migration->executedAt = $this->dateTime('executed_at');
        $migration->executionTime = $this->int('execution_time');
        
        parent::run();
    }
}
