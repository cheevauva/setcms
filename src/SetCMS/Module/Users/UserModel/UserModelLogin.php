<?php

namespace SetCMS\Module\Users\UserModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

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
        $entity->username = $this->username;
        
        return parent::bind($entity);
    }
}
