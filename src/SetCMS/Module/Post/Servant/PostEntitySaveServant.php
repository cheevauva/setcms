<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\FactoryInterface;
use SetCMS\Module\Post\DAO\PostEntityRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostEntitySaveDAO;
use SetCMS\Module\Post\PostEntity;

class PostEntitySaveServant extends \SetCMS\Entity\Servant\EntitySaveServant
{

    use \SetCMS\DITrait;

    protected function entity(): PostEntity
    {
        return new PostEntity;
    }

    protected function retrieveEntityById(): PostEntityRetrieveByIdDAO
    {
        return PostEntityRetrieveByIdDAO::make($this->factory());
    }

    protected function saveEntity(): PostEntitySaveDAO
    {
        return PostEntitySaveDAO::make($this->factory());
    }

}
