<?php

declare(strict_types=1);

namespace SetCMS\Module\User\UserEntity;

class PasswordVO
{

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

}
