<?php

declare(strict_types=1);

namespace Module\RAD01\Servant;

use Module\RAD01\DAO\RAD01HasByIdDAO;
use Module\RAD01\DAO\RAD01CreateDAO;
use Module\RAD01\DAO\RAD01UpdateDAO;

class RAD01SaveServant extends \UUA\Servant
{

    use \SetCMS\Entity\Traits\EntityCallTrait;

    #[\Override]
    protected function run(): void
    {
        if (RAD01HasByIdDAO::call($this, $this->entity->id)->isExists) {
            RAD01UpdateDAO::call($this, $this->entity);
        } else {
            RAD01CreateDAO::call($this, $this->entity);
        }
    }
}
