<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use Module\Post\PostEntity;
use Module\Post\DAO\PostHasByIdDAO;
use Module\Post\DAO\PostSaveDAO;
use Module\Post\Exception\PostNotFoundException;

class PostUpdateServant extends \UUA\Servant
{

    public PostEntity $post;

    public function serve(): void
    {
        $hasById = PostHasByIdDAO::new($this->container);
        $hasById->id = $this->post->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new PostNotFoundException;
        }

        $saveEntity = PostSaveDAO::new($this->container);
        $saveEntity->post = $this->post;
        $saveEntity->serve();
    }
}
