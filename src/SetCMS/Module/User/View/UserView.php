<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\UserRoleEnum;

class UserView
{

    public function __construct(protected UserEntity $user)
    {
        ;
    }


}
