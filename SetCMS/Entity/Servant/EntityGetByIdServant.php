<?php

declare(strict_types=1);

namespace SetCMS\Entity\Servant;

use SetCMS\Entity\Entity;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;

/**
 * @template T as Entity
 */
abstract class EntityGetByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    /**
     * @var T
     */
    public Entity $entity;

    #[\Override]
    protected function run(): void
    {
        $getById = $this->manyByCriteria();
        $getById->allowEmptyResult = false;
        $getById->expectOne = true;
        $getById->id = $this->id;
        $getById->limit = 1;
        $getById->serve();

        $this->entity = $getById->entity;
    }

    /**
     * @return EntityRetrieveByCriteriaDAO<T>
     */
    abstract protected function manyByCriteria(): EntityRetrieveByCriteriaDAO;
}
