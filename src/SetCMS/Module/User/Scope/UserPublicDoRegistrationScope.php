<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\Servant\UserRegistrationServant;
use SetCMS\Attribute\NotBlank;
use SetCMS\Attribute\Http\Parameter\Body;

class UserPublicDoRegistrationScope extends \SetCMS\Scope
{

    #[NotBlank]
    #[Body('username')]
    public string $username;

    #[NotBlank]
    #[Body('password')]
    public string $password;

    #[NotBlank]
    #[Body('password2')]
    public string $password2;
    //public string $captcha;
    protected ?UserEntity $user = null;

    public function validate(): \Iterator
    {
        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
            yield ['password', 'Пароли не совпадают'];
            yield ['password2', 'Пароли не совпадают'];
        }

        if (mb_strlen($this->password) < 8) {
            yield ['password', 'Пароль должен содержать минимум 8 символов'];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

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
