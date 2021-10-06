<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
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
    public function read(OrdinaryModelRead $model, ServerRequestInterface $request): OrdinaryModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');

        return $this->service->read($model->fromArray($params));
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     * @setcms-access-level-index
     */
    public function index(ServerRequestInterface $request, OrdinaryModelList $model): OrdinaryModelList
    {
        return $this->service->list($model->fromArray($request->getQueryParams()));
    }



}
