<?php

declare(strict_types=1);

namespace Module\RAD99\Servant;

use Module\RAD99\DAO\RAD99GetByIdDAO;
use Module\RAD99\DAO\RAD99UpdateDAO;

class RAD99DeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    public function serve(): void
    {
        $rad99 = RAD99GetByIdDAO::call($this->container, $this->id)->rad99;
        $rad99->markDeleted();

        RAD99UpdateDAO::call($this->container, $rad99);
    }
}
