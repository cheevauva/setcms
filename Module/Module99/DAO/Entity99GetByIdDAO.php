<?php

declare(strict_types=1);

namespace Module\Module99\DAO;

use Module\Module99\DAO\Entity99RetrieveByCriteriaDAO;
use Module\Module99\Entity\Entity99Entity;

class Entity99GetByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\CallWithUUIDTrait;

    public protected(set) Entity99Entity $entity99;

    #[\Override]
    public function serve(): void
    {
        $getOne = Entity99RetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->deleted = false;
        $getOne->serve();

        $this->entity99 = $getOne->entity99;
    }
}
