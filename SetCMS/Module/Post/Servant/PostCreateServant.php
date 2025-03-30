<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostHasByIdDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostAlreadyExistsException;

class PostCreateServant extends \UUA\Servant
{

    public PostEntity $post;

    public function serve(): void
    {
        $hasEntityById = PostHasByIdDAO::new($this->container);
        $hasEntityById->id = $this->post->id;
        $hasEntityById->serve();

        if ($hasEntityById->isExists) {
            throw new PostAlreadyExistsException;
        }

        $saveEntity = PostSaveDAO::new($this->container);
        $saveEntity->post = $this->post;
        $saveEntity->serve();
    }
}
