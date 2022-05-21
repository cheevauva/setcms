<?php

declare(strict_types=1);

namespace SetCMS\Module\Post;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Post\Servant\PostEntitySaveServant;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveManyDAO;
use SetCMS\Module\Post\DAO\PostEntityDbRetrieveByIdDAO;
use SetCMS\Module\Post\Scope\PostPrivateReadScope;
use SetCMS\Module\Post\Scope\PostPrivateSaveScope;
use SetCMS\Module\Post\Scope\PostPrivateEditScope;
use SetCMS\Module\Post\Scope\PostPrivateIndexScope;

class PostPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, PostPrivateIndexScope $scope, PostEntityDbRetrieveManyDAO $servant): PostPrivateIndexScope
    {
        return $this->protectedServe($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, PostPrivateReadScope $scope, PostEntityDbRetrieveByIdDAO $servant): PostPrivateReadScope
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

    public function edit(ServerRequestInterface $request, PostPrivateEditScope $scope, PostEntityDbRetrieveByIdDAO $servant): PostPrivateEditScope
    {
        return $this->protectedServe($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function save(ServerRequestInterface $request, PostPrivateSaveScope $scope, PostEntitySaveServant $servant): PostPrivateSaveScope
    {
        $servant->id = $request->getAttribute('id');

        return $this->protectedServe($request, $servant, $scope, $request->getParsedBody());
    }

    public function delete(ServerRequestInterface $request, PostDeleteForm $scope, PostEntitySaveServant $servant): PostDeleteForm
    {
        $servant->id = $request->getAttribute('id');

        return $this->protectedServe($request, $servant, $scope, []);
    }

}
