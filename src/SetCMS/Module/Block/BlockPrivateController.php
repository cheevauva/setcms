<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

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

    public function index(BlockPrivateIndexScope $scope, BlockRetrieveManyDAO $servant): BlockPrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    public function read(BlockPrivateReadScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(BlockPrivateEditScope $scope): BlockPrivateEditScope
    {
        return $scope;
    }

    public function edit(BlockPrivateEditScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    public function create(BlockPrivateCreateScope $scope, BlockCreateServant $servant): BlockPrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

    public function update(BlockPrivateUpdateScope $scope): BlockPrivateUpdateScope
    {
        return $this->multiserve([
            BlockRetrieveByIdDAO::class,
            BlockUpdateServant::class,
        ], $scope);
    }

}
