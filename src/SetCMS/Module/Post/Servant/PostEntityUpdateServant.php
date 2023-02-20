<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;

class PostEntityUpdateServant extends \SetCMS\Entity\Servant\EntityUpdateServant
{

    use \SetCMS\DITrait;

    protected function retrieveEntityById(): PostRetrieveByIdDAO
    {
        return PostRetrieveByIdDAO::make($this->factory());
    }

    protected function save(): PostSaveDAO
    {
        return PostSaveDAO::make($this->factory());
    }

}
