<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostIndexScope;
use SetCMS\Module\Post\Scope\PostReadBySlugScope;
use SetCMS\Module\Post\DAO\PostEntityRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostEntityRetrieveManyDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostIndexScope $scope, PostEntityRetrieveManyDAO $servant): PostIndexScope
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugScope $scope, PostEntityRetrieveBySlugDAO $servant): PostReadBySlugScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
