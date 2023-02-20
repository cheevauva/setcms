<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostIndexScope;
use SetCMS\Module\Post\Scope\PostReadBySlugScope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostIndexScope $scope, PostRetrieveManyDAO $servant): PostIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugScope $scope, PostRetrieveBySlugDAO $servant): PostReadBySlugScope
    {
        return $this->serve($request, $servant, $scope, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
