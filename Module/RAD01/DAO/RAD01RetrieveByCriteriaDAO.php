<?php

declare(strict_types=1);

namespace Module\RAD01\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD01\Exception\RAD01EntitiesNotFoundException;
use Module\RAD01\Exception\RAD01EntityExpectOneButReceivedTooMuchException;
use Module\RAD01\Exception\RAD01EntityNotFoundException;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Mapper\RAD01FromRowMapper;

class RAD01RetrieveByCriteriaDAO extends \SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO
{

    use \Module\RAD01\Traits\RAD01DbalDAOTrait;

    // field-repeat-start
    public string $field01;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField01UcASC;
    // field-repeat-end

    /**
     * @var array<RAD01Entity>
     */
    public protected(set) array $rad01s = [];
    public protected(set) RAD01Entity $rad01;
    public protected(set) ?RAD01Entity $rad01OrNull = null;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->rad01s = array_map(fn($row) => RAD01FromRowMapper::call($this->container, $row)->rad01, $rows);
        $this->rad01s ? $this->rad01 = $this->rad01OrNull = $this->rad01s[0] : null;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new RAD01EntitiesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new RAD01EntityExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new RAD01EntityNotFoundException;
    }

    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = $this->createQuery();

        $this->addCriteriaByFields($qb);

        return $qb;
    }

    protected function addCriteriaByFields(DatabaseQueryBuilder $qb): void
    {
        // field-repeat-start
        if (isset($this->field01)) {
            $qb->andWhere('field01 = :field01');
            $qb->setParameter('field01', $this->field01);
        }
        
        // field-repeat-end
        // field-repeat-start
        if (isset($this->sortField01UcASC)) {
            $qb->addOrderBy('field01', $this->sortField01UcASC ? 'ASC' : 'DESC');
        }
        
        // field-repeat-end
    }
}
