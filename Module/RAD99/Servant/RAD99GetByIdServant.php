<?php

declare(strict_types=1);

namespace Module\RAD99\Servant;

use SetCMS\Entity\Servant\EntityGetByIdServant;
use Module\RAD99\DAO\RAD99RetrieveByCriteriaDAO;
use Module\RAD99\Entity\RAD99Entity;

/**
 * @extends EntityGetByIdServant<RAD99Entity>
 */
class RAD99GetByIdServant extends EntityGetByIdServant
{

    #[\Override]
    protected function manyByCriteria(): RAD99RetrieveByCriteriaDAO
    {
        return RAD99RetrieveByCriteriaDAO::new($this);
    }
}
