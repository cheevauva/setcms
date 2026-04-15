<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use Module\Module01\DAO\Entity01HasByIdDAO;
use Module\Module01\DAO\Entity01CreateDAO;

class Entity01CreateServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntityCreateServantTrait;
    use \Module\Module01\Traits\Entity01CallTrait;

    #[\Override]
    protected function hasById(): bool
    {
        return Entity01HasByIdDAO::call($this->container, $this->entity01->id)->isExists;
    }

    #[\Override]
    protected function create(): void
    {
        Entity01CreateDAO::call($this->container, $this->entity01);
    }
}
