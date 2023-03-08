<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01HasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01AlreadyExistsException;

class Entity01CreateServant implements Servant
{

    use \SetCMS\DITrait;

    public Entity01Entity $Entity01LC;

    public function serve(): void
    {
        $hasEntityById = Entity01HasByIdDAO::make($this->factory());
        $hasEntityById->id = $this->Entity01LC->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new Entity01AlreadyExistsException;
        }

        $saveEntity = Entity01SaveDAO::make($this->factory());
        $saveEntity->Entity01LC = $this->Entity01LC;
        $saveEntity->serve();
    }

}
