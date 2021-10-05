<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Users\UserDAO;
use SetCMS\Module\Users\User;

class UserService extends OrdinaryService
{

    private UserDAO $dao;

    public function __construct(UserDAO $userDAO)
    {
        $this->dao = $userDAO;
    }

    protected function dao(): UserDAO
    {
        return $this->dao;
    }

    protected function newEntity(): User
    {
        return new User;
    }

}
