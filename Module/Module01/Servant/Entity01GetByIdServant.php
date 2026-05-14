<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01GetByIdServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public protected(set) Entity01Entity $entity01;

    #[\Override]
    public function serve(): void
    {
        $getOne = Entity01RetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->limit = 1;
        $getOne->serve();

        $this->entity01 = $getOne->entity01;
    }
}
