<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostPublicIndexScope;
use SetCMS\Module\Post\Scope\PostPublicReadBySlugScope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;

class PostPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostPublicIndexScope $scope, PostRetrieveManyDAO $servant): PostPublicIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostPublicReadBySlugScope $scope, PostRetrieveBySlugDAO $servant): PostPublicReadBySlugScope
    {
        $servant->throwExceptionIfNotFound = true;

        return $this->serve($request, $servant, $scope, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
