<?php

declare(strict_types=1);

namespace SetCMS\DAO;

use SetCMS\Entity\Entity;
use SetCMS\Database\DatabaseQueryBuilder;

abstract class EntitySaveDAO extends EntityCommonDAO
{

    protected Entity $entity;

    protected function has(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->entity->id);
        $qb->setMaxResults(1);

        return $qb;
    }

    protected function update(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->update($this->table());
        $qb->andWhere('id = :id');
        $qb->setMaxResults(1);
        $qb->setParameter('id', $this->entity->id);

        foreach ($this->asRow($this->entity) as $key => $value) {
            $qb->set($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }

    protected function insert(): DatabaseQueryBuilder
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->insert($this->table());

        foreach ($this->asRow($this->entity) as $key => $value) {
            $qb->setValue($key, sprintf(':%s', $key));
            $qb->setParameter($key, $value);
        }

        return $qb;
    }

    public function serve(): void
    {
        if (!!$this->has()->fetchOne()) {
            $this->update()->executeQuery();
        } else {
            $this->insert()->executeQuery();
        }
    }
}
