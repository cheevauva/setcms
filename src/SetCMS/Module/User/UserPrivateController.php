<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

use SetCMS\Module\User\DAO\UserEntityDbRetrieveManyDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\Scope\UserPrivateEditScope;
use SetCMS\Module\User\Scope\UserPrivateIndexScope;
use SetCMS\Module\User\Scope\UserPrivateSaveScope;
use SetCMS\Module\User\Scope\UserPrivateReadScope;

class UserPrivateController
{

    use \SetCMS\ControllerTrait;

    public function index(UserPrivateIndexScope $scope, UserEntityDbRetrieveManyDAO $servant): UserPrivateIndexScope
    {
        return $this->serve($servant, $scope, []);
    }

    public function read(UserPrivateReadScope $scope, UserEntityDbRetrieveByIdDAO $servant): UserPrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    public function new(UserPrivateEditScope $scope): UserPrivateEditScope
    {
        return $scope;
    }

    public function edit(UserPrivateEditScope $scope, UserEntityDbRetrieveByIdDAO $servant): UserPrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    public function save(UserPrivateSaveScope $scope, $servant): UserPrivateSaveScope
    {
        return $this->serve($servant, $scope);
    }

}
