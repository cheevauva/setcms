<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\UUID;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\DAO\PostSaveDAO;
use SetCMS\Module\Post\Exception\PostNotFoundException;

class PostDeleteServant extends \UUA\Servant
{

    public ?PostEntity $post = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $postById = PostRetrieveManyByCriteriaDAO::new($this->container);
        $postById->id = $this->id ?? ($this->post->id ?? throw new \RuntimeException('id is undefined'));
        $postById->serve();

        if (!$postById->first) {
            throw new PostNotFoundException;
        }

        $post = PostEntity::as($postById->first);
        $post->deleted = true;

        $save = PostSaveDAO::new($this->container);
        $save->entity = $post;
        $save->serve();

        $this->post = $post;
    }
}
