<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

abstract class EntitySaveDAO extends EntityCommonDAO
{

    protected Entity $entity;

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
            $this->db()->update($this->table(), $this->asRow($this->entity), ['id' => $this->entity->id]);
        } else {
            $this->db()->insert($this->table(), $this->asRow($this->entity));
        }
    }

}
