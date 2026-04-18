<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Database\Database;

trait EntityDeleteByIdDAOTrait
{

    use \UUA\Traits\AsTrait;
    use \SetCMS\Traits\CallWithUUIDTrait;

    public function serve(): void
    {
        $this->createQuery()->executeQuery();
    }

    abstract protected function table(): string;

    abstract protected function db(): Database;

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
