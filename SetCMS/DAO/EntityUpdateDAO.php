<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\Entity;
use SetCMS\Mapper\EntityToRowMapper;

/**
 * @template Entity of Entity
 * @template Mapper of EntityToRowMapper
 */
abstract class EntityUpdateDAO extends SQLCommonDAO
{

    /**
     * @var Entity
     */
    public Entity $entity;

    /**
     * @var array<string, mixed>
     */
    protected array $row;

    #[\Override]
    public function serve(): void
    {
        $this->prepareRow();
        $this->updateRow();
    }

    protected function updateRow(): void
    {
        $this->createQuery()->executeQuery();
    }

    /**
     * @return Mapper<Entity>
     */
    abstract protected function mapper(): EntityToRowMapper;

    protected function prepareRow(): void
    {
        $mapper = $this->mapper();
        $mapper->entity = $this->entity;
        $mapper->serve();

        $this->row = $mapper->row;
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->update($this->table());
        $qb->andWhere('id = :id');
        $qb->setMaxResults(1);
        $qb->setParameter('id', $this->entity->id);

        foreach ($this->row as $key => $value) {
            $qb->set($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }
}
