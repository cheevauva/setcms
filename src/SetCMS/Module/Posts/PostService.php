<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Ordinary\OrdinaryService;

class PostService extends OrdinaryService
{

    private PostDAO $dao;

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
