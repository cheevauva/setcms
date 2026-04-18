<?php

declare(strict_types=1);

namespace Module\Module99\DAO;

use SetCMS\Enum\SortEnum;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module99\Exception\Entity99EntitiesNotFoundException;
use Module\Module99\Exception\Entity99EntityExpectOneButReceivedTooMuchException;
use Module\Module99\Exception\Entity99EntityNotFoundException;
use Module\Module99\Entity\Entity99Entity;
use Module\Module99\Mapper\Entity99FromRowMapper;

abstract class Entity99RetrieveByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityRetrieveByCriteriaDAOTrait;
    use \Module\Module99\Traits\Entity99DbalDAOTrait;

    // field-repeat-start
    public string $field99;
    // field-repeat-end
    // field-repeat-start
    public SortEnum $sortByField01Uc;
    // field-repeat-end

    public protected(set) Entity99Entity $entity99;
    public protected(set) ?Entity99Entity $entity99OrNull = null;

    /**
     * @var array<Entity99Entity>
     */
    public protected(set) array $entities = [];

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

        // field-repeat-start
        $this->addCriteriaByField01Uc($qb);
        // field-repeat-end
        // field-repeat-start
        $this->addSortByField01Uc($qb);
        // field-repeat-end

        return $qb;
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->entities = array_map(fn($row) => Entity99FromRowMapper::call($this->container, $row)->entity99, $rows);
        $this->entities ? $this->entity99 = $this->entity99OrNull = $this->entities[0] : null;
    }

    // field-repeat-start
    protected function addSortByField01Uc(DatabaseQueryBuilder $qb): void
    {
        if (isset($this->sortByField01Uc)) {
            $qb->addOrderBy('field99', $this->sortByField01Uc->value);
        }
    }

    // field-repeat-end
    // field-repeat-start
    protected function addCriteriaByField01Uc(DatabaseQueryBuilder $qb): void
    {
        if (isset($this->field99)) {
            $qb->andWhere('field99 = :field99');
            $qb->setParameter('field99', $this->field99);
        }
    }

    // field-repeat-end
}
