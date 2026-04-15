<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use SetCMS\UUID;
use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01GetByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\CallWithUUIDTrait;

    public protected(set) Entity01Entity $entity01;

    #[\Override]
    public function serve(): void
    {
        $getOne = Entity01RetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->serve();

        $this->entity01 = $getOne->entity01;
    }
}
