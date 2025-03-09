<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Common\Entity\Entity;
use SetCMS\Common\Mapper\EntityMapper;

abstract class EntityCommonDAO extends \UUA\DAO
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

    /**
     * @param Entity $entity
     * @return array<string, mixed>
     */
    protected function asRow(Entity $entity): array
    {
        $mapper = $this->mapper();
        $mapper->entity = $entity;
        $mapper->serve();
        
        if (is_null($mapper->row)) {
            throw new \RuntimeException('row must be array');
        }
        
        return $mapper->row;
    }

    /**
     * @param array<string, mixed> $row
     * @return Entity
     */
    protected function asEntity(array $row): Entity
    {
        $mapper = $this->mapper();
        $mapper->row = $row;
        $mapper->serve();

        return Entity::as($mapper->entity);
    }

    /**
     * @param array<array<string, mixed>> $rows
     * @return array<Entity>
     */
    protected function asEntities(array $rows): array
    {
        $entities = [];

        foreach ($rows as $row) {
            $entities[] = $this->asEntity($row);
        }

        return $entities;
    }
}
