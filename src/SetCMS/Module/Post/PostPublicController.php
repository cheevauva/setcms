<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Scope\PostIndexScope;
use SetCMS\Module\Post\Scope\PostReadBySlugScope;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyDAO;

class PostPublicController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostIndexScope $scope, PostEntityDbRetrieveManyDAO $servant): PostIndexScope
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

    public function readBySlug(ServerRequestInterface $request, PostReadBySlugScope $scope, PostEntityDbRetrieveBySlugDAO $servant): PostReadBySlugScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'slug' => $request->getAttribute('slug'),
        ]);
    }

}
