<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\UserModel\UserModelSave;

class UserResource
{

    use \SetCMS\Module\Ordinary\OrdinaryResourceTrait;

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $this->service($userService);
    }

    public function update(ServerRequestInterface $request, UserModelSave $model): UserModelSave
    {
        return $this->save($request, $model);
    }

}
