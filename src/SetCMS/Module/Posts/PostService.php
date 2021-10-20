<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Posts\PostModel\PostModelRead;

class PostService extends OrdinaryService
{

    private PostDAO $dao;

    public function read(OrdinaryModelRead $model): void
    {
        if ($model instanceof PostModelRead && $model->slug) {
            $entity = $this->dao()->getBySlug($model->slug);
        } else {
            $entity = $this->dao()->get($model->id);
        }
        
        $model->entity($entity);
    }

    public function __construct(PostDAO $dao)
    {
        $this->dao = $dao;
    }

    protected function dao(): PostDAO
    {
        return $this->dao;
    }

    public function entity(): Post
    {
        return new Post;
    }

}
