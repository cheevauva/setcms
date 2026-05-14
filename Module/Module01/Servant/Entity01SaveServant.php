<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use Module\Module01\DAO\Entity01HasByIdDAO;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\DAO\Entity01UpdateDAO;

class Entity01SaveServant extends \UUA\Servant
{

    use \Module\Module01\Traits\Entity01CallTrait;

    #[\Override]
    public function serve(): void
    {
        if (Entity01HasByIdDAO::call($this->container, $this->entity01->id)->isExists) {
            Entity01UpdateDAO::call($this->container, $this->entity01);
        } else {
            Entity01CreateDAO::call($this->container, $this->entity01);
        }
    }
}
