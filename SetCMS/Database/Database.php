<?php

declare(strict_types=1);

namespace SetCMS\Database;

use SetCMS\Database\DatabaseQueryBuilder;

class Database extends \Doctrine\DBAL\Connection
{

    public string $connectionName;

    public function connectionDriverName(): string
    {
        return match ($this->getParams()['driver'] ?? null) {
            'pdo_sqlite' => 'sqlite',
            'pdo_mysql' => 'mysql',
            'pdo_pgsql' => 'pgsql',
            default => throw new \Exception(sprintf('connectionDriverName не может быть определен для %s', $this->getParams()['driver'] ?? 'null')),
        };
    }

    #[\Override]
    public function createQueryBuilder(): DatabaseQueryBuilder
    {
        return new DatabaseQueryBuilder($this);
    }
}
