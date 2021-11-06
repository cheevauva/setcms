<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Ordinary\OrdinaryResourceController;
use SetCMS\Module\Users\UserModel\UserModelSave;

class UserResource
{

    private OrdinaryResourceController $ordinaryAdmin;

    public function __construct(UserService $userService, OrdinaryResourceController $ordinaryAdmin)
    {
        $this->ordinaryAdmin = $ordinaryAdmin;
        $this->ordinaryAdmin->service($userService);
    }

    public function update(ServerRequestInterface $request, UserModelSave $model): UserModelSave
    {
        return $this->ordinaryAdmin->save($request, $model);
    }

}
