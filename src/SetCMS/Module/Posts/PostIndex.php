<?php

namespace SetCMS\Module\Posts;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Posts\PostModel\PostModelRead;
use SetCMS\Module\Posts\PostService;

class PostIndex
{

    use \SetCMS\Module\Ordinary\OrdinaryIndexTrait;

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $this->service($postService);
    }

    /**
     * @setcms-request-method-get
     * @setcms-response-content-html
     */
    public function readBySlug(ServerRequestInterface $request, PostModelRead $model): PostModelRead
    {
        $params = $request->getQueryParams();
        $params['slug'] = $request->getAttribute('slug');

        $model->fromArray($params);

        if ($model->isValid()) {
            $this->postService->readBySlug($model);
        }

        return $model;
    }

}
