<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

use SetCMS\UUID;
use Module\Migration\Entity\MigrationEntity;

class MigrationMapper extends \SetCMS\Mapper\EntityMapper
{

    #[\Override]
    protected function entity2row(): void
    {
        $migration = MigrationEntity::as($this->entity);

        $this->row = [];
        $this->row['version'] = $migration->version;
        $this->row['executed_at'] = $migration->executedAt->format('Y-m-d H:i:s');
        $this->row['execution_time'] = $migration->executionTime;
    }

    #[\Override]
    protected function entity4row(): void
    {
        $this->row['id'] = (new UUID)->uuid;
        $this->row['entity_type'] = MigrationEntity::class;
        $this->row['date_created'] = gmdate('Y-m-d H:i:s');
        $this->row['date_modified'] = gmdate('Y-m-d H:i:s');
        $this->row['deleted'] = 0;

        parent::entity4row();

        $migration = MigrationEntity::as($this->entity);
        $migration->version = strval($this->row['version'] ?? throw new \Exception());
        $migration->executedAt = new \DateTimeImmutable($this->row['executed_at'] ?? throw new \Exception());
        $migration->executionTime = intval($this->row['execution_time'] ?? throw new \Exception());
    }
}
