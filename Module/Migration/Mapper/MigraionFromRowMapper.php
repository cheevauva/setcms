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
        $entity = $this->entity = new MigrationEntity();
        $entity->version = $this->string('version');
        $entity->executedAt = $this->dateTime('executed_at');
        $entity->executionTime = $this->int('execution_time');
        
        parent::run();
    }
}
