<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

use Module\Migration\Entity\MigrationEntity;

class MigraionToRowMapper extends \SetCMS\Entity\Mapper\EntityToRowMapper
{

    #[\Override]
    protected function run(): void
    {
        $migration = MigrationEntity::as($this->entity);

        $this->row['version'] = $migration->version;
        $this->row['executed_at'] = $migration->executedAt->format('Y-m-d H:i:s');
        $this->row['execution_time'] = $migration->executionTime;

        parent::run();
    }
}
