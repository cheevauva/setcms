<?php

namespace SetCMS\Module\Users;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class User extends OrdinaryEntity
{

    public string $username;
    public bool $isAdmin = false;
    protected string $password;

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

}
