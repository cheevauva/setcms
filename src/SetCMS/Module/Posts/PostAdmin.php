<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostService;

class PostAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait;

    public function __construct(PostService $postService)
    {
        $this->service($postService);
    }

}
