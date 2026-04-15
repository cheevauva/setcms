<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\Enum\SortEnum;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Exception\Entity01EntitiesNotFoundException;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;
use Module\Module01\Exception\Entity01EntityNotFoundException;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01FromRowMapper;

abstract class Entity01RetrieveByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityRetrieveByCriteriaDAOTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;

    // field-repeat-start
    public string $field01;
    // field-repeat-end
    // field-repeat-start
    public SortEnum $sortByField01Uc;
    // field-repeat-end

    public protected(set) Entity01Entity $entity01;
    public protected(set) ?Entity01Entity $entity01OrNull = null;

    /**
     * @var array<Entity01Entity>
     */
    public protected(set) array $entities = [];

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new Entity01EntitiesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new Entity01EntityExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new Entity01EntityNotFoundException;
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
        $this->entities = array_map(fn($row) => Entity01FromRowMapper::call($this->container, $row)->entity, $rows);

        if (isset($this->entities[0])) {
            $this->entity01 = $this->entity01OrNull = $this->entities[0];
        }
    }

    // field-repeat-start
    protected function addSortByField01Uc(DatabaseQueryBuilder $qb): void
    {
        if (isset($this->sortByField01Uc)) {
            $qb->addOrderBy('field01', $this->sortByField01Uc->value);
        }
    }

    // field-repeat-end
    // field-repeat-start
    protected function addCriteriaByField01Uc(DatabaseQueryBuilder $qb): void
    {
        if (isset($this->field01)) {
            $qb->andWhere('field01 = :field01');
            $qb->setParameter('field01', $this->field01);
        }
    }

    // field-repeat-end
}
