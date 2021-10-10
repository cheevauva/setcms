<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostModel\PostModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Posts\PostService;

class PostIndex
{

    private PostService $service;

    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function readBySlug(PostModelRead $model, ServerRequestInterface $request): PostModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');
        $params['slug'] = $request->getAttribute('slug');

        $model->fromArray($params);
        
        if ($model->isValid()) {
            $this->service->readBySlug($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function read(PostModelRead $model, ServerRequestInterface $request): PostModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');
        $params['slug'] = $request->getAttribute('slug');

        $model->fromArray($params);

        if ($model->isValid()) {
            $this->service->read($model);
        }

        return $model;
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
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
