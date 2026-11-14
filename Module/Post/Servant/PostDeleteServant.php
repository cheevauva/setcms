<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostDeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsCallWithUUID;

    #[\Override]
    protected function run(): void
    {
        $entity = PostGetByIdDAO::call($this, $this->id)->entity;
        $entity->markDeleted();

        PostUpdateDAO::call($this, $entity);
    }
}
