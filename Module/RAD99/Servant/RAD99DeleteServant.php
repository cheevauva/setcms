<?php

declare(strict_types=1);

namespace Module\RAD99\Servant;

use Module\RAD99\DAO\RAD99GetByIdDAO;
use Module\RAD99\DAO\RAD99UpdateDAO;

class RAD99DeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    protected function run(): void
    {
        $entity = RAD99GetByIdDAO::call($this, $this->id)->entity;
        $entity->markDeleted();

        RAD99UpdateDAO::call($this, $entity);
    }
}
