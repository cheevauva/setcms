<?php

declare(strict_types=1);

namespace SetCMS\Module\User\View;

use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;

class UserView
{

    public function __construct(protected UserEntity $user)
    {
        ;
    }
}
