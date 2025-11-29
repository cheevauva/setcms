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
abstract class EntityCreateDAO extends SQLCommonDAO
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
        $this->insertRow();
    }

    protected function insertRow(): void
    {
        $this->createQuery()->executeQuery();
    }

    protected function prepareRow(): void
    {
        $mapper = $this->mapper();
        $mapper->entity = $this->entity;
        $mapper->serve();

        $this->row = $mapper->row;
    }

    /**
     * @return Mapper<Entity>
     */
    abstract protected function mapper(): EntityToRowMapper;

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->insert($this->table());

        foreach ($this->row as $key => $value) {
            $qb->setValue($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }
}
