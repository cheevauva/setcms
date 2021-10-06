<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Posts\PostModel\PostModelSave;
use SetCMS\Module\Posts\PostService;

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
     * @setcms-access-level-admin
     */
    public function edit(ServerRequestInterface $request, OrdinaryModelRead $model): OrdinaryModelRead
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id');

        return $this->service->read($model->fromArray($params));
    }

    /**
     * @setcms-request-method-post
     * @setcms-response-content-json
     * @setcms-access-level-admin
     */
    public function save(ServerRequestInterface $request, PostModelSave $model): PostModelSave
    {
        return $this->service->save($model->fromArray($request->getParsedBody()));
    }

}
