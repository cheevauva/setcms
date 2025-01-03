<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Module\Post\Scope\PostPublicIndexScope;
use SetCMS\Module\Post\Scope\PostPublicReadBySlugScope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;

class PostPublicController
{

    use \SetCMS\Traits\ControllerTrait;
    use \SetCMS\Traits\RouterTrait;

    public function index(PostPublicIndexScope $scope, PostRetrieveManyDAO $servant): PostPublicIndexScope
    {
        return $this->serve($servant, $scope);
    }

    public function readBySlug(PostPublicReadBySlugScope $scope, PostRetrieveBySlugDAO $servant): PostPublicReadBySlugScope
    {
        return $this->serve($servant, $scope);
    }

}
