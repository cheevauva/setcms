<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Posts\PostModel\PostModelRead;

class PostService extends OrdinaryService
{

    private PostDAO $dao;

    public function read(OrdinaryModelRead $model): PostModelRead
    {
        assert($model instanceof PostModelRead);

        if ($model->id) {
            parent::read($model);
        }

        if ($model->slug) {
            $model->entity($this->dao()->getBySlug($model->slug));
        }

        return $model;
    }

    public function __construct(PostDAO $dao)
    {
        $this->dao = $dao;
    }

    protected function dao(): PostDAO
    {
        return $this->dao;
    }

    protected function newEntity(): Post
    {
        return new Post;
    }

}
