<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Exception\Entity01EntitiesNotFoundException;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;
use Module\Module01\Exception\Entity01EntityNotFoundException;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01FromRowMapper;

class Entity01RetrieveByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;
    use \Module\Module01\Traits\Entity01DbalDAOTrait;

    // field-repeat-start
    public string $field01;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField01UcASC;
    // field-repeat-end

    /**
     * @var array<Entity01Entity>
     */
    public protected(set) array $entity01s = [];
    public protected(set) Entity01Entity $entity01;
    public protected(set) ?Entity01Entity $entity01OrNull = null;

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->entity01s = array_map(fn($row) => Entity01FromRowMapper::call($this->container, $row)->entity01, $rows);
        $this->entity01s ? $this->entity01 = $this->entity01OrNull = $this->entity01s[0] : null;
    }

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
