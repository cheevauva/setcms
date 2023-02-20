<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use SetCMS\UUID;

abstract class EntityHasByIdDAO extends EntityCommonDAO
{

    public UUID $id;
    public ?bool $isExists = null;

    public function serve(): void
    {
        $qb = $this->db()->createQueryBuilder();
        $qb->select('id');
        $qb->from($this->table());
        $qb->andWhere('id = :id');
        $qb->setParameter('id', $this->id);
        $qb->setMaxResults(1);

        $this->isExists = !!$qb->fetchOne();
    }

}
