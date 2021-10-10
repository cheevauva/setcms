<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostService;
use SetCMS\Module\Posts\PostModel\PostModelSave;
use SetCMS\Module\Posts\PostModel\PostModelCreate;
use SetCMS\Module\Ordinary\OrdinaryController;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class PostAdmin
{

    private OrdinaryController $ordinaryAdmin;
    private PostService $service;

    public function __construct(PostService $postService, OrdinaryController $ordinaryAdmin)
    {
        $this->ordinaryAdmin = $ordinaryAdmin;
        $this->ordinaryAdmin->service($postService);

        $this->service = $postService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function saveform(ServerRequestInterface $request, PostModelCreate $createModel, OrdinaryModelRead $editModel): OrdinaryModel
    {
        return $this->ordinaryAdmin->saveform($request, $request->getAttribute('id') ? $editModel : $createModel);
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->ordinaryAdmin->index($request, $model);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function read(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        return $this->ordinaryAdmin->read($request, $model);
    }

}
