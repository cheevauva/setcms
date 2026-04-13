<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\Database;
use SetCMS\Database\DatabaseQueryBuilder;

trait EntityUpdateDAOTrait
{

    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    abstract protected function id(): string;

    /**
     * @return array<string, mixed>
     */
    abstract protected function row(): array;

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->update($this->table());
        $qb->andWhere('id = :id');
        $qb->setMaxResults(1);
        $qb->setParameter('id', $this->id());

        foreach ($this->row() as $key => $value) {
            $qb->set($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }
}
