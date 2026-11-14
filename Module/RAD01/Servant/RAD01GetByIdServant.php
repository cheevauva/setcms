<?php

declare(strict_types=1);

namespace Module\RAD01\Servant;

use SetCMS\Entity\Servant\EntityGetByIdServant;
use Module\RAD01\DAO\RAD01RetrieveByCriteriaDAO;
use Module\RAD01\Entity\RAD01Entity;

/**
 * @extends EntityGetByIdServant<RAD01Entity>
 */
class RAD01GetByIdServant extends EntityGetByIdServant
{

    #[\Override]
    protected function manyByCriteria(): RAD01RetrieveByCriteriaDAO
    {
        return RAD01RetrieveByCriteriaDAO::new($this);
    }
}
