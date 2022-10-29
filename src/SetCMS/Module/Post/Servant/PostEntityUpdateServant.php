<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Post\DAO\PostEntityRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostEntitySaveDAO;

class PostEntityUpdateServant extends \SetCMS\Entity\Servant\EntityUpdateServant
{

    use \SetCMS\DITrait;

    protected function retrieveEntityById(): PostEntityRetrieveByIdDAO
    {
        return PostEntityRetrieveByIdDAO::make($this->factory());
    }

    protected function saveEntity(): PostEntitySaveDAO
    {
        return PostEntitySaveDAO::make($this->factory());
    }

}
