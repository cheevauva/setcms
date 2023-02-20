<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\ServantInterface;
use SetCMS\Entity;
use SetCMS\Entity\Mapper\EntityMapper;

abstract class EntityCommonDAO implements ServantInterface
{

    protected ?int $limit = null;
    protected int $offset = 0;

    abstract protected function db(): Connection;

    abstract protected function mapper(): EntityMapper;

    abstract protected function table(): string;

    protected function createQuery(): QueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table());
        $qb->setMaxResults($this->limit);
        $qb->setFirstResult($this->offset);

        return $qb;
    }

    protected function entity2row(Entity $entity): array
    {
        $mapper = $this->mapper();
        $mapper->entity = $entity;
        $mapper->row = null;
        $mapper->serve();

        return $mapper->row;
    }

    protected function entity4row(array $row): Entity
    {
        $mapper = $this->mapper();
        $mapper->entity = null;
        $mapper->row = $row;
        $mapper->serve();

        return $mapper->entity;
    }

}
