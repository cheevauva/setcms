<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class User extends OrdinaryEntity
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_GUEST = 'guest';

    public string $username;
    public bool $isAdmin = false;
    protected string $password;
    public string $role = User::ROLE_USER;

    public static function hashPassword(string $password): string
    {
        return md5($password);
    }

    public function password(?string $password = null)
    {
        if (is_null($password)) {
            return $this->password;
        }

        return $this->password = $password;
    }

    public function hasRole(string $role): bool
    {
        return $role === $this->role;
    }

}
