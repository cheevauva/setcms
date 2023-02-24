<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Entity\Servant\EntityUpdateServant;
use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;

class PostEntityUpdateServant extends EntityUpdateServant
{

    use \SetCMS\DITrait;

    protected function save(): PostSaveDAO
    {
        return PostSaveDAO::make($this->factory());
    }

    protected function hasById(): PostHasByIdDAO
    {
        return PostHasByIdDAO::make($this->factory());
    }

    protected function notFoundException(): \Exception
    {
        return new \Exception;
    }

}
