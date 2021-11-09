<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Users\UserService;

class UserAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryControllerTrait;

    public function __construct(UserService $userService)
    {
        $this->service($userService);
    }

}
