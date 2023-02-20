<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Entity\Servant\EntityDeleteServant;
use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01DeleteServant extends EntityDeleteServant
{

    use \SetCMS\DITrait;

    public ?Entity01Entity $Entity01LC = null;

    public function serve(): void
    {
        $this->entity = $this->Entity01LC;

        parent::serve();
    }

    protected function retrieveById(): Entity01RetrieveByIdDAO
    {
        return Entity01RetrieveByIdDAO::make($this->factory());
    }

    protected function save(): Entity01SaveDAO
    {
        return Entity01SaveDAO::make($this->factory());
    }

    protected function notFoundException(): \Exception
    {
        return new Entity01NotFoundException;
    }

}
