<?php

declare(strict_types=1);

namespace Module\RAD99\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD99\Exception\RAD99EntitiesNotFoundException;
use Module\RAD99\Exception\RAD99EntityExpectOneButReceivedTooMuchException;
use Module\RAD99\Exception\RAD99EntityNotFoundException;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Mapper\RAD99FromRowMapper;

class RAD99RetrieveByCriteriaDAO extends \Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO
{

    use \Module\RAD99\Traits\RAD99DbalDAOTrait;

    // field-repeat-start
    public string $field99;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField99UcASC;
    // field-repeat-end

    /**
     * @var array<RAD99Entity>
     */
    public protected(set) array $rad99s = [];
    public protected(set) RAD99Entity $rad99;
    public protected(set) ?RAD99Entity $rad99OrNull = null;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->rad99s = array_map(fn($row) => RAD99FromRowMapper::call($this->container, $row)->rad99, $rows);
        $this->rad99s ? $this->rad99 = $this->rad99OrNull = $this->rad99s[0] : null;
    }

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new RAD99EntitiesNotFoundException;
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new RAD99EntityExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new RAD99EntityNotFoundException;
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
