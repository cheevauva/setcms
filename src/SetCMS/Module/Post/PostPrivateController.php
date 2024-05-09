<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
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

    public function index(ServerRequestInterface $request, PostPrivateIndexScope $scope, PostRetrieveManyDAO $servant): PostPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadScope $scope, PostRetrieveByIdDAO $servant): PostPrivateReadScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function new(ServerRequestInterface $request, PostPrivateEditScope $scope): PostPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, PostPrivateEditScope $scope, PostRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function create(ServerRequestInterface $request, PostPrivateCreateScope $scope, PostCreateServant $servant): PostPrivateCreateScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function update(ServerRequestInterface $request, PostPrivateUpdateScope $scope): PostPrivateUpdateScope
    {
        return $this->multiserve($request, [
            PostRetrieveByIdDAO::make($this->factory()),
            PostUpdateServant::make($this->factory())
        ], $scope);
    }

}
