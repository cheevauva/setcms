<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostDeleteByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostDeleteServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntityDeleteServantTrait;

    #[\Override]
    protected function delete(): void
    {
        PostDeleteByIdDAO::call($this->container, $this->entity()->id);
    }

    #[\Override]
    protected function entity(): PostEntity
    {
        return PostGetByIdDAO::call($this->container, $this->id)->post;
    }

    #[\Override]
    protected function update(): void
    {
        PostUpdateDAO::call($this->container, $this->entity());
    }
}
