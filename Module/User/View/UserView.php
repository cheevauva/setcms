<?php

declare(strict_types=1);

namespace Module\User\View;

use Module\User\Entity\UserEntity;

class UserView
{

    public function __construct(protected UserEntity $user)
    {
        ;
    }
}
