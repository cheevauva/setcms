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
abstract class EntityRetrieveManyDAO extends SQLCommonDAO
{

    public ?int $limit = null;
    public int $offset = 0;
    public UUID $id;
    public bool $deleted;
    public \Throwable $throwIfEmpty;

    /**
     * @var class-string
     */
    protected string $clsMapper;

    /**
     * @var array<E>
     */
    public protected(set) array $entities = [];

    /**
     * @var array<string, mixed>
     */
    protected array $criteria = [];

    #[\Override]
    public function serve(): void
    {
        $this->throwIfEmpty ??= new \Exception('Запись не найдена');
        $this->entities = $this->entities4rows($this->createQuery()->fetchAllAssociative() ?: []);
    }

    /**
     * @return EntityFromRowMapper<E>
     */
    protected function mapper(): EntityFromRowMapper
    {
        return EntityFromRowMapper::as(($this->clsMapper)::new($this->container));
    }

    /**
     * @param array<int,array<string,mixed>> $rows
     * @return array<E>
     */
    protected function entities4rows(array $rows): array
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

    /**
     * @return E
     */
    public function first(): Entity
    {
        return $this->entities[0] ?? throw $this->throwIfEmpty;
    }
}
