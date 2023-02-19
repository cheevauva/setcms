<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthApp\DAO\OAuthAppEntityRetrieveManyDAO;
use SetCMS\Module\OAuth\OAuthApp\DAO\OAuthAppEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthApp\Scope\OAuthAppPrivateReadScope;
use SetCMS\Module\OAuth\OAuthApp\Scope\OAuthAppPrivateEditScope;
use SetCMS\Module\OAuth\OAuthApp\Scope\OAuthAppPrivateIndexScope;
use SetCMS\Module\OAuth\OAuthApp\Scope\OAuthAppPrivateCreateScope;
use SetCMS\Module\OAuth\OAuthApp\Scope\OAuthAppPrivateUpdateScope;
use SetCMS\Module\OAuth\OAuthApp\Servant\OAuthAppEntityCreateServant;
use SetCMS\Module\OAuth\OAuthApp\Servant\OAuthAppEntityUpdateServant;

class OAuthAppPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Controller\DynamicControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, OAuthAppPrivateIndexScope $scope, OAuthAppEntityRetrieveManyDAO $servant): OAuthAppPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, OAuthAppPrivateReadScope $scope, OAuthAppEntityRetrieveByIdDAO $servant): OAuthAppPrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, OAuthAppPrivateEditScope $scope): OAuthAppPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, OAuthAppPrivateEditScope $scope, OAuthAppEntityRetrieveByIdDAO $servant): OAuthAppPrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, OAuthAppPrivateCreateScope $scope, OAuthAppEntityCreateServant $servant): OAuthAppPrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, OAuthAppPrivateUpdateScope $scope, OAuthAppEntityUpdateServant $update, OAuthAppEntityRetrieveByIdDAO $readById): OAuthAppPrivateUpdateScope
    {
        return $this->multiserve($request, [$readById, $update], $scope, $request->getParsedBody());
    }

}
