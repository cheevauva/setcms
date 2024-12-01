<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\UUID;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;

class UserPrivateUserScope extends UserPrivateScope
{

    public UserRoleEnum $role;
    public UUID $id;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof UserEntity) {
            $object->role = $this->role;
        }
    }

}
