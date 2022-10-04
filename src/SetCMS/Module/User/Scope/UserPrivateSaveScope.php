<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\UserRoleEnum;

class UserPrivateSaveScope extends \SetCMS\Entity\Scope\EntitySaveScope
{

    public UserRoleEnum $role;

    public function __construct()
    {
        $this->entity = new UserEntity;
    }

    public function apply(object $object): void
    {
        if ($object instanceof UserEntity) {
            $object->role = $this->role;
        }
    }

}
