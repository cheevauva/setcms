<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;

class PostEntityCreateServant extends \SetCMS\Entity\Servant\EntityCreateServant
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

}
