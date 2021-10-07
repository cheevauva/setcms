<?php

namespace SetCMS\Module\Users\UserModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Users\User;

class UserModelLogin extends OrdinaryModel
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

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): \SetCMS\Module\Ordinary\OrdinaryEntity
    {
        assert($entity instanceof User);

        $entity->username = $this->username;
        $entity->password(User::hashPassword($this->password));

        return parent::bind($entity);
    }

}
