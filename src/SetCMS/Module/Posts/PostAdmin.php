<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Posts\PostModel\PostModelSave;
use SetCMS\Module\Posts\PostService;
use SetCMS\Module\Posts\PostModel\PostModelCreate;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

class PostAdmin
{

    private PostService $service;

    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function edit(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');

        $model->fromArray($params);

        if ($model->isValid()) {
            $this->service->read($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function create(ServerRequestInterface $request, PostModelCreate $model): PostModelCreate
    {
        $model->fromArray($request->getQueryParams());
        $model->entity(new Post);

        return $model;
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     */
    public function save(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        $model->fromArray($request->getParsedBody());

        if ($model->isValid()) {
            $this->service->save($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        $model->fromArray($request->getQueryParams());

        if ($model->isValid()) {
            $this->service->list($model);
        }

        return $model;
    }

}
