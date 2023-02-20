<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Entity\Servant\EntityCreateServant;
use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostAlreadyExistsException;

class PostEntityCreateServant extends EntityCreateServant
{

    use \SetCMS\DITrait;

    protected function hasEntityById(): PostHasByIdDAO
    {
        return PostHasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): PostSaveDAO
    {
        return PostSaveDAO::make($this->factory());
    }

    protected function alreadyExistsException(): PostAlreadyExistsException
    {
        return new PostAlreadyExistsException;
    }
}
