<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

trait DAOEntityCreateTrait
{

    #[\Override]
    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function row(): array;

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->insert($this->table());

        foreach ($this->row() as $key => $value) {
            $qb->setValue($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }
}
