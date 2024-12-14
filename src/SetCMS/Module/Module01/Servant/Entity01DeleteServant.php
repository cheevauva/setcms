<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01DeleteServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;

    public ?Entity01Entity $Entity01LC = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $retrieveById = Entity01RetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->id ?? $this->Entity01LC->id;
        $retrieveById->serve();

        if (!$retrieveById->entity) {
            throw new Entity01NotFoundException;
        }

        $entity = $retrieveById->Entity01LC;
        $entity->deleted = true;

        $save = Entity01SaveDAO::make($this->factory());
        $save->entity = $entity;
        $save->serve();

        $this->entity = $entity;
    }

}
