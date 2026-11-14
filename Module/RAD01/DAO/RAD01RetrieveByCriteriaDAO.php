<?php

declare(strict_types=1);

namespace Module\RAD01\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Mapper\RAD01FromRowMapper;

/**
 * @extends EntityRetrieveByCriteriaDAO<RAD01Entity>
 */
class RAD01RetrieveByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\RAD01\Traits\RAD01DbalDAOTrait;

    // field-repeat-start
    public string $field01;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField01UcASC;

    // field-repeat-end


    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = parent::createQb();

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

    #[\Override]
    protected function rowToEntity(array $row): RAD01Entity
    {
        return RAD01FromRowMapper::call($this, $row)->entity;
    }
}
