<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

abstract class EntityHasByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public protected(set) bool $isExists;

    #[\Override]
    public function serve(): void
    {
        $this->isExists = !!$this->createQuery()->fetchOne();
    }

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->id);
        $qb->setMaxResults(1);

        return $qb;
    }
}
