<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\Servant\UserRegistrationServant;

class UserDoRegistrationScope extends \SetCMS\Scope
{

    public string $username;
    public string $password;
    public string $password2;
    //public string $captcha;
    protected ?UserEntity $user = null;

    public function satisfy(): \Iterator
    {
        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
            yield ['Пароли не совпадают', 'password2'];
        }

//        if (mb_strlen($this->password) < 8) {
//            yield ['Пароль должен содержать минимум 8 символов', 'password'];
//        }
    }

    public function to(object $object): void
    {
        if ($object instanceof UserRegistrationServant) {
            $object->username = $this->username;
            $object->password = $this->password;
        }
    }

    public function toArray(): array
    {
        return [
            'entity' => $this->user,
        ];
    }

}
