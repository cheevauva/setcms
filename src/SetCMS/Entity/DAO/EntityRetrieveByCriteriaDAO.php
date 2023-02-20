<?php

declare(strict_types=1);

namespace SetCMS\Entity\DAO;

use Doctrine\DBAL\Query\QueryBuilder;
use SetCMS\Entity;

abstract class EntityRetrieveByCriteriaDAO extends EntityCommonDAO
{

    protected array $criteria = [];
    protected ?int $limit = 1;
    public ?Entity $entity = null;
    public ?array $row = null;

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