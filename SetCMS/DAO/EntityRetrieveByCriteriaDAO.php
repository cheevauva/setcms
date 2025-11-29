<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\Entity;
use SetCMS\UUID;
use SetCMS\Mapper\EntityFromRowMapper;

/**
 * @template Entity of Entity
 * @template Mapper of EntityFromRowMapper
 */
abstract class EntityRetrieveByCriteriaDAO extends SQLCommonDAO
{

    public ?int $limit = null;
    public int $offset = 0;
    public UUID $id;
    public bool $deleted;

    /**
     * @var array<string, mixed>
     */
    protected array $criteria = [];

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function retrieveRows(): array
    {
        return $this->createQuery()->fetchAllAssociative();
    }

    #[\Override]
    public function serve(): void
    {
        $this->handleRows($this->retrieveRows());
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     */
    abstract protected function handleRows(array $rows): void;

    /**
     * @return Mapper<Entity>
     */
    abstract protected function mapper(): EntityFromRowMapper;

    /**
     * @param array<int,array<string,mixed>> $rows
     * @return array<Entity>
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
