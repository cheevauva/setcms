<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateIndexScope;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateEditScope;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateReadScope;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateCreateScope;
use SetCMS\Module\OAuth\OAuthClient\Scope\OAuthClientPrivateUpdateScope;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveManyDAO;
use SetCMS\Module\OAuth\OAuthClient\Servant\OAuthClientEntityCreateServant;
use SetCMS\Module\OAuth\OAuthClient\Servant\OAuthClientEntityUpdateServant;

class OAuthClientPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Controller\DynamicControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, OAuthClientPrivateIndexScope $form, OAuthClientEntityRetrieveManyDAO $servant): OAuthClientPrivateIndexScope
    {
        return $this->serve($request, $servant, $form, []);
    }

    public function new(ServerRequestInterface $request, OAuthClientPrivateEditScope $scope): OAuthClientPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function read(ServerRequestInterface $request, OAuthClientPrivateReadScope $scope, OAuthClientEntityRetrieveByIdDAO $servant): OAuthClientPrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function edit(ServerRequestInterface $request, OAuthClientPrivateEditScope $scope, OAuthClientEntityRetrieveByIdDAO $servant): OAuthClientPrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, OAuthClientPrivateCreateScope $form, OAuthClientEntityCreateServant $servant): OAuthClientPrivateCreateScope
    {
        return $this->serve($request, $servant, $form, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, OAuthClientPrivateUpdateScope $form, OAuthClientEntityRetrieveByIdDAO $readById, OAuthClientEntityUpdateServant $update): OAuthClientPrivateUpdateScope
    {
        return $this->multiserve($request, [$readById, $update], $form, $request->getParsedBody());
    }

}
