<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Entity\Servant\EntityCreateServant;
use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01HasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01AlreadyExistsException;

class Entity01CreateServant extends EntityCreateServant
{

    use \SetCMS\DITrait;

    public Entity01Entity $Entity01LC;

    public function serve(): void
    {
        $this->entity = $this->Entity01LC;

        parent::serve();
    }

    protected function hasEntityById(): Entity01EntityHasByIdDAO
    {
        return Entity01HasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): Entity01EntitySaveDAO
    {
        return Entity01SaveDAO::make($this->factory());
    }

    protected function alreadyExistsException(): Entity01AlreadyExistsException
    {
        return new Entity01AlreadyExistsException;
    }

}
