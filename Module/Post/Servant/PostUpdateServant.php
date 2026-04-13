<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\Entity\PostEntity;
use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostUpdateServant extends \UUA\Servant
{

    use \SetCMS\Servant\EntityUpdateServantTrait;

    public PostEntity $post;

    #[\Override]
    protected function hasById(): bool
    {
        return PostHasByIdDAO::call($this->container, $this->post->id)->isExists;
    }

    #[\Override]
    protected function update(): void
    {
        PostUpdateDAO::call($this->container, $this->post);
    }
}
