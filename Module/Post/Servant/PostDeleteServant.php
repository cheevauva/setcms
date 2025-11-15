<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\UUID;
use Module\Post\PostEntity;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use Module\Post\DAO\PostSaveDAO;
use Module\Post\Exception\PostNotFoundException;

class PostDeleteServant extends \UUA\Servant
{

    public ?PostEntity $post = null;
    public ?UUID $id = null;

    public function serve(): void
    {
        $postById = PostRetrieveManyByCriteriaDAO::new($this->container);
        $postById->id = $this->id ?? ($this->post->id ?? throw new \RuntimeException('id is undefined'));
        $postById->serve();

        if (!$postById->post) {
            throw new PostNotFoundException;
        }

        $post = PostEntity::as($postById->post);
        $post->deleted = true;

        $save = PostSaveDAO::new($this->container);
        $save->post = $post;
        $save->serve();

        $this->post = $post;
    }
}
