<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\Entity;
use SetCMS\UUID;
use SetCMS\Mapper\EntityFromRowMapper;

/**
 * @template E of Entity
 * @template M of EntityFromRowMapper
 */
abstract class EntityRetrieveByCriteriaDAO extends SQLCommonDAO
{

    public ?int $limit = null;
    public int $offset = 0;
    public UUID $id;
    public bool $deleted;

    /**
     * @var class-string
     */
    protected string $clsMapper;

    /**
     * @var array<string, mixed>
     */
    protected array $criteria = [];

    /**
     * @return M<E>
     */
    protected function mapper(): EntityFromRowMapper
    {
        return EntityFromRowMapper::as(($this->clsMapper)::new($this->container));
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function retrieveAll(): array
    {
        return $this->createQuery()->fetchAllAssociative() ?: [];
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     * @return array<E>
     */
    protected function entitiesFromRows(array $rows): array
    {
        $entities = [];

        foreach ($rows as $row) {
            $mapper = $this->mapper();
            $mapper->row = $row;
            $mapper->serve();

            $entities[] = $mapper->entity;
        }

        return $entities;
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('*');
        $qb->from($this->table());
        $qb->setMaxResults($this->limit);
        $qb->setFirstResult($this->offset);

        if (isset($this->deleted)) {
            $qb->andWhere('deleted = :deleted');
            $qb->setParameter('deleted', intval($this->deleted));
        }

        if (isset($this->id)) {
            $qb->andWhere('id = :id');
            $qb->setParameter('id', $this->id->uuid);
            $qb->setMaxResults(1);
        }

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s.%s = :%s', $this->table(), $field, $field));
            $qb->setParameter($field, $value);
        }

        return $qb;
    }
}
