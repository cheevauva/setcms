<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostService;
use SetCMS\Module\Ordinary\OrdinaryController;

class PostAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryCRUD;

    public function __construct(PostService $postService, OrdinaryController $ordinaryAdmin)
    {
        $this->ordinary($ordinaryAdmin);
        $this->ordinary()->service($postService);
    }

}
