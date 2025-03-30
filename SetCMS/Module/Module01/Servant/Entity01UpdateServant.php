<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01HasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01UpdateServant extends \UUA\Servant
{

    public Entity01Entity $Entity01LC;

    #[\Override]
    public function serve(): void
    {
        $hasById = Entity01HasByIdDAO::new($this->container);
        $hasById->id = $this->Entity01LC->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new Entity01NotFoundException;
        }

        $saveEntity = Entity01SaveDAO::new($this->container);
        $saveEntity->Entity01LC = $this->Entity01LC;
        $saveEntity->serve();
    }
}
