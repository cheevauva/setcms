<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;

abstract class EntityDeleteByIdDAO extends SQLCommonDAO
{

    public UUID $id;

    #[\Override]
    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();
        $qb->delete($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->id->uuid);
        $qb->setMaxResults(1);

        return $qb;
    }
}
