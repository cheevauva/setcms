<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Common\Entity\Entity;

abstract class EntityRetrieveByCriteriaDAO extends EntityCommonDAO
{

    protected array $criteria = [];
    protected ?int $limit = 1;
    protected ?array $row = null;
    protected ?Entity $entity = null;

    public function serve(): void
    {
        $qb = $this->createQuery();
        $this->row = $qb->fetchAssociative() ?: null;
        $this->entity = $this->row ? $this->entity4row($this->row) : null;
    }

    protected function createQuery(): QueryBuilder
    {
        $qb = parent::createQuery();

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s = :%s', $field, $field));
        }

        $qb->setParameters($this->criteria);

        return $qb;
    }

}
