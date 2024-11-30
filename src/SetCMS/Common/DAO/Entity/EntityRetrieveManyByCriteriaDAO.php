<?php

declare(strict_types=1);

namespace SetCMS\Common\DAO\Entity;

abstract class EntityRetrieveManyByCriteriaDAO extends EntityRetrieveManyDAO
{

    protected array $criteria = [];
    protected ?int $limit = null;
    protected bool $forUpdate = false;

    public function serve(): void
    {
        $qb = $this->createQuery();

        foreach ($this->criteria as $field => $value) {
            $qb->andWhere(sprintf('%s = :%s', $field, $field));
            $qb->setParameter($field, $value);
        }

        $this->entities = $this->prepareEntitiesByRows($qb->executeQuery()->iterateAssociative());
    }

}
