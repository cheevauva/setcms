<?php

declare(strict_types=1);

namespace Module\RAD01\Servant;

use Module\RAD01\DAO\RAD01RetrieveByCriteriaDAO;
use Module\RAD01\Entity\RAD01Entity;

class RAD01GetByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public protected(set) RAD01Entity $rad01;

    #[\Override]
    public function serve(): void
    {
        $getOne = RAD01RetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->limit = 1;
        $getOne->serve();

        $this->rad01 = $getOne->rad01;
    }
}
