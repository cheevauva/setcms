<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\UUID;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01DeleteServant extends \UUA\Servant
{

    public ?Entity01Entity $Entity01LC = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $Entity01LCById = Entity01RetrieveByIdDAO::new($this->container);
        $Entity01LCById->id = $this->id ?? ($this->Entity01LC->id ?? throw new \RuntimeException('id is undefined'));
        $Entity01LCById->serve();

        if (!$Entity01LCById->first) {
            throw new Entity01NotFoundException;
        }

        $Entity01LC = Entity01Entity::as($Entity01LCById->first);
        $Entity01LC->deleted = true;

        $save = Entity01SaveDAO::new($this->container);
        $save->entity = $Entity01LC;
        $save->serve();

        $this->Entity01LC = $Entity01LC;
    }
}
