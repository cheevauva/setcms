<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\Scope\PostPrivateReadScope;
use SetCMS\Module\Post\Scope\PostPrivateEditScope;
use SetCMS\Module\Post\Scope\PostPrivateIndexScope;
use SetCMS\Module\Post\Scope\PostPrivateCreateScope;
use SetCMS\Module\Post\Scope\PostPrivateUpdateScope;
use SetCMS\Module\Post\Servant\PostCreateServant;
use SetCMS\Module\Post\Servant\PostUpdateServant;

class PostPrivateController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(PostPrivateIndexScope $scope, PostRetrieveManyDAO $servant): PostPrivateIndexScope
    {
        return $this->serve($servant, $scope, []);
    }

    public function read(PostPrivateReadScope $scope, PostRetrieveByIdDAO $servant): PostPrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(PostPrivateEditScope $scope): PostPrivateEditScope
    {
        return $scope;
    }

    public function edit(PostPrivateEditScope $scope, PostRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    public function create(PostPrivateCreateScope $scope, PostCreateServant $servant): PostPrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

    public function update(PostPrivateUpdateScope $scope): PostPrivateUpdateScope
    {
        return $this->multiserve([
            PostRetrieveByIdDAO::make($this->factory()),
            PostUpdateServant::make($this->factory())
        ], $scope);
    }

}
