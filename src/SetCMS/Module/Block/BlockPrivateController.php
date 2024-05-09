<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

use \Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Block\DAO\BlockRetrieveManyDAO;
use SetCMS\Module\Block\DAO\BlockRetrieveByIdDAO;
use SetCMS\Module\Block\Scope\BlockPrivateReadScope;
use SetCMS\Module\Block\Scope\BlockPrivateEditScope;
use SetCMS\Module\Block\Scope\BlockPrivateIndexScope;
use SetCMS\Module\Block\Scope\BlockPrivateCreateScope;
use SetCMS\Module\Block\Scope\BlockPrivateUpdateScope;
use SetCMS\Module\Block\Servant\BlockCreateServant;
use SetCMS\Module\Block\Servant\BlockUpdateServant;

class BlockPrivateController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function index(ServerRequestInterface $request, BlockPrivateIndexScope $scope, BlockRetrieveManyDAO $servant): BlockPrivateIndexScope
    {
        return $this->serve($request, $servant, $scope, []);
    }

    public function read(ServerRequestInterface $request, BlockPrivateReadScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateReadScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function new(ServerRequestInterface $request, BlockPrivateEditScope $scope): BlockPrivateEditScope
    {
        $this->secureByScope($scope, $request);

        return $scope;
    }

    public function edit(ServerRequestInterface $request, BlockPrivateEditScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateEditScope
    {
        return $this->serve($request, $servant, $scope);
    }

    public function create(ServerRequestInterface $request, BlockPrivateCreateScope $scope, BlockCreateServant $servant): BlockPrivateCreateScope
    {
        return $this->serve($request, $servant, $scope, $request->getParsedBody());
    }

    public function update(ServerRequestInterface $request, BlockPrivateUpdateScope $scope, BlockUpdateServant $update, BlockRetrieveByIdDAO $readById): BlockPrivateUpdateScope
    {
        return $this->multiserve($request, [
            $readById,
            $update
        ], $scope, $request->getParsedBody());
    }

}
