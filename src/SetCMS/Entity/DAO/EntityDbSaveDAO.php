<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\Entity;
use SetCMS\UUID;

abstract class EntityDbSaveDAO extends EntityDbDAO
{

    public Entity $entity;

    private function has(UUID $id): bool
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $id);
        $qb->setMaxResults(1);

        return !!$qb->fetchOne();
    }

    public function serve(): void
    {
        if ($this->has($this->entity->id)) {
            $this->db()->update($this->table(), $this->entity2row($this->entity), ['id' => $this->entity->id]);
        } else {
            $this->db()->insert($this->table(), $this->entity2row($this->entity));
        }
    }

}
