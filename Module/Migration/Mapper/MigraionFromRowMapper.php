<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

use Module\Migration\Entity\MigrationEntity;
use Module\Migration\Exception\MigrationMapperNotFoundKeyInRowException;

class MigraionFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public protected(set) MigrationEntity $migration;

    #[\Override]
    public function serve(): void
    {
        $this->migration = new MigrationEntity();
        $this->migration->version = $this->string('version');
        $this->migration->executedAt = $this->dateTime('executed_at');
        $this->migration->executionTime = $this->int('execution_time');
    }

    #[\Override]
    protected function notFoundKeyInRowException(string $key): MigrationMapperNotFoundKeyInRowException
    {
        throw new MigrationMapperNotFoundKeyInRowException($key);
    }
}
