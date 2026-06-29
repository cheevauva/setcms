<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

abstract class EntityDeleteByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    abstract protected function table(): string;

    abstract protected function db(): Database;

    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->delete($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->id->uuid);

        return $qb;
    }
}
