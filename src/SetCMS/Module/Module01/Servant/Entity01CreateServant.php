<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Servant;

use SetCMS\Module\Module01\DAO\Entity01EntityHasByIdDAO;
use SetCMS\Module\Module01\DAO\Entity01EntitySaveDAO;

class Entity01CreateServant extends \SetCMS\Entity\Servant\EntityCreateServant
{

    use \SetCMS\DITrait;

    protected function hasEntityById(): Entity01EntityHasByIdDAO
    {
        return Entity01EntityHasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): Entity01EntitySaveDAO
    {
        return Entity01EntitySaveDAO::make($this->factory());
    }

}
