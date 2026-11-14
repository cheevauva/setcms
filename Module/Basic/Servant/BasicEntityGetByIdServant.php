<?php

declare(strict_types=1);

namespace Module\Basic\Servant;

use SetCMS\Entity\Servant\EntityGetByIdServant;
use Module\Basic\DAO\BasicEntityRetrieveByCriteriaDAO;
use Module\Basic\Entity\BasicEntity;
use SetCMS\Entity\Entity;

/**
 * @template T of BasicEntity
 * @extends EntityGetByIdServant<T>
 */
abstract class BasicEntityGetByIdServant extends EntityGetByIdServant
{

    /**
     * @var T
     */
    public Entity $entity;

    /**
     * @return BasicEntityRetrieveByCriteriaDAO<T>
     */
    #[\Override]
    abstract protected function manyByCriteria(): BasicEntityRetrieveByCriteriaDAO;
}
