<?php

declare(strict_types=1);

namespace SetCMS\Module\User;

class UserEntity extends \SetCMS\Entity
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_GUEST = 'guest';

    public string $username;
    public string $password;
    public string $role = UserEntity::ROLE_ADMIN;// @todo поменять на пользовательскую роль

    public function hasRole(string $role): bool
    {
        return $role === $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }

}
