<?php

declare(strict_types=1);

namespace Module\Module99\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module99\Exception\Entity99EntitiesNotFoundException;
use Module\Module99\Exception\Entity99EntityExpectOneButReceivedTooMuchException;
use Module\Module99\Exception\Entity99EntityNotFoundException;
use Module\Module99\Entity\Entity99Entity;
use Module\Module99\Mapper\Entity99FromRowMapper;

abstract class Entity99RetrieveByCriteriaDAO extends \SetCMS\Entity\DAO\EntityBasicRetrieveByCriteriaDAO
{

    use \Module\Module99\Traits\Entity99DbalDAOTrait;

    // field-repeat-start
    public string $field99;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField99UcASC;
    // field-repeat-end

    /**
     * @var array<Entity99Entity>
     */
    public protected(set) array $entities = [];
    public protected(set) Entity99Entity $entity99;
    public protected(set) ?Entity99Entity $entity99OrNull = null;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->entities = array_map(fn($row) => Entity99FromRowMapper::call($this->container, $row)->entity99, $rows);
        $this->entities ? $this->entity99 = $this->entity99OrNull = $this->entities[0] : null;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new Entity99EntitiesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new Entity99EntityExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new Entity99EntityNotFoundException;
    }

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        $this->basicQb($qb);
        $this->addCriteriaByFields($qb);

        return $qb;
    }

    protected function addCriteriaByFields(DatabaseQueryBuilder $qb): void
    {
        // field-repeat-start
        if (isset($this->field99)) {
            $qb->andWhere('field99 = :field99');
            $qb->setParameter('field99', $this->field99);
        }

        // field-repeat-end
        // field-repeat-start
        if (isset($this->sortField99UcASC)) {
            $qb->addOrderBy('field99', $this->sortField99UcASC ? 'ASC' : 'DESC');
        }
        // field-repeat-end
    }
}
