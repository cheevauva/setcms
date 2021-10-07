<?php

namespace SetCMS\Module\Users\UserModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Users\User;

class UserModelRegistration extends OrdinaryModel
{

    /**
     * @setcms-required
     * @setcms-type-string
     * @var string 
     */
    public string $username = '';

    /**
     * @setcms-required
     * @setcms-type-string
     * @var string 
     */
    public string $password = '';

    /**
     * @setcms-required
     * @setcms-type-string
     * @var string 
     */
    public string $password2 = '';

    public function isValid(): bool
    {
        parent::isValid();

        if (!empty($this->password) && !empty($this->password2) && $this->password !== $this->password2) {
            $this->addMessage('Пароли не совпадают', 'password2');
        }

        if (mb_strlen($this->password) < 8) {
            $this->addMessage('Пароль должен содержать минимум 8 символов', 'password');
        }

        return empty($this->messages);
    }

    protected function bind(OrdinaryEntity $entity): User
    {
        assert($entity instanceof User);

        $entity->username = $this->username;
        $entity->password(User::hashPassword($this->password));

        return $entity;
    }

}
