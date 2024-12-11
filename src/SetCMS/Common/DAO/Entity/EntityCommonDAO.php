<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Application\Contract\ContractServant;
use SetCMS\Common\Entity\Entity;
use SetCMS\Common\Mapper\EntityMapper;

abstract class EntityCommonDAO implements ContractServant
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

    protected function asRow(Entity $entity): array
    {
        $mapper = $this->mapper();
        $mapper->entity = $entity;
        $mapper->row = null;
        $mapper->serve();

        return $mapper->row;
    }

    protected function asEntity(array $row): Entity
    {
        $mapper = $this->mapper();
        $mapper->entity = null;
        $mapper->row = $row;
        $mapper->serve();

        return $mapper->entity;
    }

    protected function asEntities(array $rows): array
    {
        $entities = [];

        foreach ($rows as $row) {
            $entities[] = $this->asEntity($row);
        }

        return $entities;
    }
}
