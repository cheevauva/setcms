<?php

declare(strict_types=1);

namespace Module\RAD99\DAO;

use Module\RAD99\DAO\RAD99RetrieveByCriteriaDAO;
use Module\RAD99\Entity\RAD99Entity;

class RAD99GetByIdDAO extends \UUA\DAO
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    public protected(set) RAD99Entity $rad99;

    #[\Override]
    public function serve(): void
    {
        $getOne = RAD99RetrieveByCriteriaDAO::new($this->container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->id = $this->id;
        $getOne->deleted = false;
        $getOne->serve();

        $this->rad99 = $getOne->rad99;
    }
}
