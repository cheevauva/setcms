<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityRetrieveManyDAO;
use SetCMS\Module\Post\DAO\PostEntityRetrieveByIdDAO;
use SetCMS\Module\Post\Scope\PostPrivateReadScope;
use SetCMS\Module\Post\Scope\PostPrivateSaveScope;
use SetCMS\Module\Post\Scope\PostPrivateEditScope;
use SetCMS\Module\Post\Scope\PostPrivateIndexScope;
use SetCMS\UUID;

class PostPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostPrivateIndexScope $scope, PostEntityRetrieveManyDAO $servant): PostPrivateIndexScope
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadScope $scope, PostEntityRetrieveByIdDAO $servant): PostPrivateReadScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, PostPrivateEditScope $scope): PostPrivateEditScope
    {
        $this->protectScopeByRequest($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, PostPrivateEditScope $scope, PostEntityRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PostPrivateSaveScope $scope, PostEntitySaveServant $servant): PostPrivateSaveScope
    {
        return $this->protectedServe($request, $servant, $scope, $request->getParsedBody());
    }

    public function delete(ServerRequestInterface $request, PostDeleteForm $scope, PostEntitySaveServant $servant): PostDeleteForm
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

}
