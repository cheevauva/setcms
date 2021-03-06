<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Entity;
use SetCMS\Entity\EntityDbMapper;

abstract class EntityDbDAO implements \SetCMS\ServantInterface
{

    protected EntityDbMapper $mapper;
    protected Connection $db;
    protected string $table;
    protected ?int $limit = null;
    protected ?int $offset = null;
    public bool $throwExceptions = false;

    protected function createQuery(): QueryBuilder
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table);
        $qb->setMaxResults($this->limit);
        $qb->setFirstResult($this->offset);

        return $qb;
    }

    protected function entity2row(Entity $entity): array
    {
        $mapper = clone $this->mapper;
        $mapper->entity = $entity;
        $mapper->row = null;
        $mapper->serve();

        return $mapper->row;
    }

    protected function entity4row(array $row): Entity
    {
        $mapper = clone $this->mapper;
        $mapper->entity = null;
        $mapper->row = $row;
        $mapper->serve();

        return $mapper->entity;
    }

}
