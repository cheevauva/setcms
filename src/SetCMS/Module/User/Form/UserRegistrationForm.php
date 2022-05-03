<?php

namespace SetCMS\Module\User\Form;

use SetCMS\Module\User\UserEntity;

class UserRegistrationForm extends \SetCMS\Form
{

    public string $username;
    public string $password;
    public string $password2;
    public string $captcha;
    protected ?UserEntity $user = null;

    public function isValid(): bool
    {
        parent::isValid();

//        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
//            $this->addMessageAsValidation('Пароли не совпадают', 'password2');
//        }
//
//        if (mb_strlen($this->password) < 8) {
//            $this->addMessageAsValidation('Пароль должен содержать минимум 8 символов', 'password');
//        }

        return empty($this->messages);
    }

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof UserRegistrationServant) {
//            $object->username = $this->username;
//            $object->password(User::passwordHash($this->password));
        }
    }

    public function toArray(): array
    {
        return [
            'entity' => $this->user,
        ];
    }

}
