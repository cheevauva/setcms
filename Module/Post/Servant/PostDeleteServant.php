<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\DAO\PostGetByIdDAO;
use Module\Post\DAO\PostUpdateDAO;

class PostDeleteServant extends \UUA\Servant
{

    use \SetCMS\Traits\CallWithUUIDTrait;

    #[\Override]
    public function serve(): void
    {
        $post = PostGetByIdDAO::call($this->container, $this->id)->post;
        $post->markDeleted();

        PostUpdateDAO::call($this->container, $post);
    }
}
