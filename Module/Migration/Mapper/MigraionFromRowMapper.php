<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

use Module\Migration\Entity\MigrationEntity;

class MigraionFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

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
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        throw new \Exception($key);
    }
}
