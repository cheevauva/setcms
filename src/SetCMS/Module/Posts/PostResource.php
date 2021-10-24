<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostService;
use SetCMS\Module\Posts\PostModel\PostModelSave;
use SetCMS\Module\Ordinary\OrdinaryResourceController;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

class PostResource
{

    private OrdinaryResourceController $ordinaryAdmin;

    public function __construct(PostService $postService, OrdinaryResourceController $ordinaryAdmin)
    {
        $this->ordinaryAdmin = $ordinaryAdmin;
        $this->ordinaryAdmin->service($postService);
    }

    public function create(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        return $this->ordinaryAdmin->read($request, $model);
    }

    public function update(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->ordinaryAdmin->index($request, $model);
    }

}
