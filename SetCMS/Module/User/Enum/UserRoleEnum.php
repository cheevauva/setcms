<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Enum;

enum UserRoleEnum: string
{

    case GUEST = 'guest';
    case USER = 'user';
    case ADMIN = 'admin';

    public function toString(): string
    {
        return $this->value;
    }
}
