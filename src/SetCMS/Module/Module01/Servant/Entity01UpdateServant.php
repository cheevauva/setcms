<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Entity\Servant\EntityUpdateServant;
use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01HasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01UpdateServant extends EntityUpdateServant
{

    use \SetCMS\DITrait;

    public Entity01Entity $Entity01LC;

    public function serve(): void
    {
        $this->entity = $this->Entity01LC;

        parent::serve();
    }

    protected function hasById(): Entity01HasByIdDAO
    {
        return Entity01HasByIdDAO::make($this->factory());
    }

    protected function save(): Entity01SaveDAO
    {
        return Entity01SaveDAO::make($this->factory());
    }

    protected function notFoundException(): Entity01NotFoundException
    {
        return new Entity01NotFoundException;
    }

}
