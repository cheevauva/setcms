<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Controller;

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

    public function index(BlockPrivateIndexScope $scope, BlockRetrieveManyDAO $servant): BlockPrivateIndexScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function read(BlockPrivateReadScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateReadScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function new(BlockPrivateEditScope $scope): BlockPrivateEditScope
    {
        return $scope;
    }

    public function edit(BlockPrivateEditScope $scope, BlockRetrieveByIdDAO $servant): BlockPrivateEditScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function create(BlockPrivateCreateScope $scope, BlockCreateServant $servant): BlockPrivateCreateScope
    {
        $this->serve($servant, $scope);

        return $scope;
    }

    public function update(BlockPrivateUpdateScope $scope): BlockPrivateUpdateScope
    {
        $this->multiserve([
            BlockRetrieveByIdDAO::class,
            BlockUpdateServant::class,
        ], $scope);

        return $scope;
    }
}
