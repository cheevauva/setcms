<?php

namespace SetCMS\Module\Users\UserModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class UserModelSave extends OrdinaryModel
{

    /**
     * @setcms-required
     * @setcms-type-string
     * @var string 
     */
    public string $id;

    /**
     * @setcms-required
     * @setcms-type-string
     * @var string 
     */
    public string $role;

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): \SetCMS\Module\Ordinary\OrdinaryEntity
    {
        $entity->role = $this->role;
        
        return $entity;
    }
}
