<?php

declare(strict_types=1);

namespace SetCMS\Module\Session;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Session\DAO\SessionRetrieveManyDAO;
use SetCMS\Module\Session\DAO\SessionRetrieveByIdDAO;
use SetCMS\Module\Session\Scope\SessionPrivateReadScope;
use SetCMS\Module\Session\Scope\SessionPrivateEditScope;
use SetCMS\Module\Session\Scope\SessionPrivateIndexScope;
use SetCMS\Module\Session\Scope\SessionPrivateCreateScope;
use SetCMS\Module\Session\Scope\SessionPrivateUpdateScope;
use SetCMS\Module\Session\Servant\SessionCreateServant;
use SetCMS\Module\Session\Servant\SessionUpdateServant;

class SessionPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, SessionPrivateIndexScope $scope, SessionRetrieveManyDAO $servant): SessionPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, SessionPrivateReadScope $scope, SessionRetrieveByIdDAO $servant): SessionPrivateReadScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function new(ServerRequestInterface $request, SessionPrivateEditScope $scope): SessionPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, SessionPrivateEditScope $scope, SessionRetrieveByIdDAO $servant): SessionPrivateEditScope
    {
        return $this->serve($request, $servant, $scope, [
            'id' => $request->getAttribute('id'),
        ]);
    }

    public function create(ServerRequestInterface $request, SessionPrivateCreateScope $scope, SessionCreateServant $servant): SessionPrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, SessionPrivateUpdateScope $scope, SessionUpdateServant $update, SessionRetrieveByIdDAO $readById): SessionPrivateUpdateScope
    {
        return $this->multiserve($request, [
            $readById,
            $update
        ], $scope, $request->getParsedBody());
    }

}
