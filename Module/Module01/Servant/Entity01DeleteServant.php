<?php

declare(strict_types=1);

namespace Module\Module01\Servant;

use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01GetByIdDAO;
use Module\Module01\DAO\Entity01DeleteByIdDAO;
use Module\Module01\DAO\Entity01UpdateDAO;

class Entity01DeleteServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntityDeleteServantTrait;

    protected Entity01Entity $entity;

    #[\Override]
    protected function delete(): void
    {
        Entity01DeleteByIdDAO::call($this->container, $this->id);
    }

    #[\Override]
    protected function entity(): Entity01Entity
    {
        return $this->entity ??= Entity01GetByIdDAO::call($this->container, $this->id)->entity01;
    }

    #[\Override]
    protected function update(): void
    {
        Entity01UpdateDAO::call($this->container, $this->entity());
    }
}
