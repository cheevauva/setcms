<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\FactoryInterface;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\PostEntity;

class PostEntitySaveServant extends \SetCMS\Entity\Servant\EntitySaveServant
{

    use \SetCMS\DITrait;

    protected function entity(): PostEntity
    {
        return new PostEntity;
    }

    protected function retrieveEntityById(): PostRetrieveByIdDAO
    {
        return PostRetrieveByIdDAO::make($this->factory());
    }

    protected function saveEntity(): PostSaveDAO
    {
        return PostSaveDAO::make($this->factory());
    }

}
