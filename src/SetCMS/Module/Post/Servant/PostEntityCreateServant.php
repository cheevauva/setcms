<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Post\DAO\PostEntityHasByIdDAO;
use SetCMS\Module\Post\DAO\PostEntitySaveDAO;

class PostEntityCreateServant extends \SetCMS\Entity\Servant\EntityCreateServant
{

    use \SetCMS\DITrait;

    protected function hasEntityById(): PostEntityHasByIdDAO
    {
        return PostEntityHasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): PostEntitySaveDAO
    {
        return PostEntitySaveDAO::make($this->factory());
    }

}
