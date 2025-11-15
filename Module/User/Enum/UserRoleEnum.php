<?php

declare(strict_types=1);

namespace Module\User\Enum;

use Module\User\UserRoleConstants;

enum UserRoleEnum: string
{

    case GUEST = UserRoleConstants::GUEST;
    case USER = UserRoleConstants::USER;
    case ADMIN = UserRoleConstants::ADMIN;

    public function toString(): string
    {
        return $this->value;
    }
}
