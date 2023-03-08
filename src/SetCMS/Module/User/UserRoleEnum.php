<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

enum UserRoleEnum: string
{

    case GUEST = 'guest';
    case USER = 'user';
    case ADMIN = 'admin';

    public function isGuest(): bool
    {
        return $this === UserRoleEnum::GUEST;
    }

    public function isAdmin(): bool
    {
        return $this === UserRoleEnum::ADMIN;
    }

    public function isUser(): bool
    {
        return $this === UserRoleEnum::USER;
    }
    
    public function toString(): string
    {
        return $this->value;
    }

}
