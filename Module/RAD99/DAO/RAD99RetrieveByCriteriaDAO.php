<?php

declare(strict_types=1);

namespace Module\RAD99\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO;
use Module\RAD99\Mapper\RAD99FromRowMapper;
use Module\RAD99\Entity\RAD99Entity;

/**
 * @extends BasicEntityRetrieveByCriteriaDAO<RAD99Entity>
 */
class RAD99RetrieveByCriteriaDAO extends BasicEntityRetrieveByCriteriaDAO
{

    use \Module\RAD99\Traits\RAD99DbalDAOTrait;

    // field-repeat-start
    public string $field99;
    // field-repeat-end
    // field-repeat-start
    public bool $sortField99UcASC;

    // field-repeat-end


    #[\Override]
    protected function createQb(): DatabaseQueryBuilder
    {
        $qb = parent::createQb();

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

        return $qb;
    }

    #[\Override]
    protected function rowToEntity(array $row): RAD99Entity
    {
        return RAD99FromRowMapper::call($this, $row)->entity;
    }
}
