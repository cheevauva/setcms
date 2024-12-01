<?php

namespace SetCMS\Module\User\Scope;

use SetCMS\Scope;
use SetCMS\Module\User\Entity\UserEntity;

class UserInfoScope extends Scope
{

    private UserEntity $user;

    public function apply(object $object): void
    {
        
    }

}
