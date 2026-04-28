<?php

declare(strict_types=1);

namespace Module\Module99\Servant;

use Module\Module99\DAO\Entity99GetByIdDAO;
use Module\Module99\DAO\Entity99UpdateDAO;

class Entity99DeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    public function serve(): void
    {
        $entity99 = Entity99GetByIdDAO::call($this->container, $this->id)->entity99;
        $entity99->markDeleted();

        Entity99UpdateDAO::call($this->container, $entity99);
    }
}
