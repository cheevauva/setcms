<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostService;
use SetCMS\Module\Posts\PostModel\PostModelSave;

class PostResource
{

    use \SetCMS\Module\Ordinary\OrdinaryResourceTrait;

    public function __construct(PostService $postService)
    {
        $this->service($postService);
    }

    public function create(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->save($request, $model);
    }

    public function update(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->save($request, $model);
    }

}
