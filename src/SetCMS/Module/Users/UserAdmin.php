<?php

namespace SetCMS\Module\Users;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;
use SetCMS\Module\Ordinary\OrdinaryController;

class UserAdmin
{

    use \SetCMS\Module\Ordinary\OrdinaryCRUD;


    public function __construct(UserService $userService, OrdinaryController $ordinary)
    {
        $this->ordinary($ordinary);
        $this->ordinary()->service($userService);
    }

}
