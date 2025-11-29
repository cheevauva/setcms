<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\Entity;
use SetCMS\Mapper\EntityToRowMapper;

/**
 * @template T of Entity
 * @template M of EntityToRowMapper
 */
abstract class EntityCreateDAO extends SQLCommonDAO
{

    /**
     * @var T
     */
    public Entity $entity;

    /**
     * @var class-string
     */
    protected string $clsMapper;

    #[\Override]
    public function serve(): void
    {
        $this->insert();
    }
    
    protected function insert(): void
    {
        $this->createQuery()->executeQuery();
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        $mapper = EntityToRowMapper::as(($this->clsMapper)::new($this->container));
        $mapper->entity = $this->entity;
        $mapper->serve();

        $qb = $this->db()->createQueryBuilder();
        $qb->insert($this->table());

        foreach ($mapper->row as $key => $value) {
            $qb->setValue($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }
}
