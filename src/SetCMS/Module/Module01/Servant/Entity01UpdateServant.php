<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01HasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01SaveDAO;
use SetCMS\Module\Module01\Exception\Entity01NotFoundException;

class Entity01UpdateServant implements ContractServant
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

    public Entity01Entity $Entity01LC;

    #[\Override]
    public function serve(): void
    {
        $hasById = Entity01HasByIdDAO::make($this->factory());
        $hasById->id = $this->Entity01LC->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new Entity01NotFoundException;
        }

        $saveEntity = Entity01SaveDAO::make($this->factory());
        $saveEntity->Entity01LC = $this->Entity01LC;
        $saveEntity->serve();
    }
}
