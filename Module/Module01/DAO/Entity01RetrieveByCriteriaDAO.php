<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\DAO\EntityRetrieveByCriteriaDAO;
use Module\Module01\Mapper\Entity01FromRowMapper;
use Module\Module01\Entity\Entity01Entity;

/**
 * @extends EntityRetrieveByCriteriaDAO<Entity01Entity, Entity01FromRowMapper>
 */
abstract class Entity01RetrieveByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use Entity01CommonDAO;

    public string $field01;

    #[\Override]
    protected function mapper(): Entity01FromRowMapper
    {
        return Entity01FromRowMapper::new($this->container);
    }

    #[\Override]
    protected function createQuery(): DatabaseQueryBuilder
    {
        isset($this->field01) ? $this->criteria['field01'] = $this->field01 : null;

        return parent::createQuery();
    }
}
