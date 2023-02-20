<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Servant\PostEntityCreateServant;
use SetCMS\Module\Post\DAO\PostRetrieveManyDAO;
use SetCMS\Module\Post\DAO\PostRetrieveByIdDAO;
use SetCMS\Module\Post\Scope\PostPrivateReadScope;
use SetCMS\Module\Post\Servant\PostEntityUpdateServant;
use SetCMS\Module\Post\Scope\PostPrivateEditScope;
use SetCMS\Module\Post\Scope\PostPrivateIndexScope;
use SetCMS\Module\Post\Scope\PostPrivateCreateScope;
use SetCMS\Module\Post\Scope\PostPrivateUpdateScope;

class PostPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostPrivateIndexScope $scope, PostRetrieveManyDAO $servant): PostPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadScope $scope, PostRetrieveByIdDAO $servant): PostPrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, PostPrivateEditScope $scope): PostPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, PostPrivateEditScope $scope, PostRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, PostPrivateCreateScope $scope, PostEntityCreateServant $servant): PostPrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, PostPrivateUpdateScope $scope, PostEntityUpdateServant $update, PostRetrieveByIdDAO $readById): PostPrivateUpdateScope
    {
        return $this->multiserve($request, [$readById, $update], $scope, $request->getParsedBody());
    }

}
