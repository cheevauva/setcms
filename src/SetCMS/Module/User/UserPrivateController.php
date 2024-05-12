<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\User\DAO\UserRetrieveManyDAO;
use SetCMS\Module\User\DAO\UserRetrieveByIdDAO;
use SetCMS\Module\User\Scope\UserPrivateEditScope;
use SetCMS\Module\User\Scope\UserPrivateIndexScope;
use SetCMS\Module\User\Scope\UserPrivateReadScope;
use SetCMS\Module\User\Scope\UserPrivateUpdateScope;
use SetCMS\Module\User\DAO\UserSaveDAO;

class UserPrivateController
{

    use \SetCMS\ControllerTrait;

    #[RequestMethod('GET')]
    public function index(UserPrivateIndexScope $scope, UserRetrieveManyDAO $servant): UserPrivateIndexScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function read(UserPrivateReadScope $scope, UserRetrieveByIdDAO $servant): UserPrivateReadScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('GET')]
    public function new(UserPrivateEditScope $scope): UserPrivateEditScope
    {
        return $scope;
    }

    #[RequestMethod('GET')]
    public function edit(UserPrivateEditScope $scope, UserRetrieveByIdDAO $servant): UserPrivateEditScope
    {
        return $this->serve($servant, $scope);
    }

    #[RequestMethod('POST')]
    public function update(UserPrivateUpdateScope $scope): UserPrivateUpdateScope
    {
        return $this->multiserve([
            UserRetrieveByIdDAO::class,
            UserSaveDAO::class,
        ], $scope);
    }

    #[RequestMethod('POST')]
    public function create(UserPrivateCreateScope $scope, $servant): UserPrivateCreateScope
    {
        return $this->serve($servant, $scope);
    }

}
