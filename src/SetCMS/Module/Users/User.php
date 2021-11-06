<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class User extends OrdinaryEntity
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_GUEST = 'guest';

    public string $module = 'Users';
    public string $resource = 'user';
    public string $username;
    protected string $password;
    public string $role = User::ROLE_USER;

    public static function passwordVerify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function password(?string $password = null)
    {
        if (is_null($password)) {
            return $this->password;
        }

        return $this->password = $password;
    }

    public function isThisYourPassword(string $password): bool
    {
        return static::passwordVerify($password, $this->password);
    }

    public function hasRole(string $role): bool
    {
        return $role === $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }

}
