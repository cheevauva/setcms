<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Controller;

use SetCMS\UUID;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Enum\UserRoleEnum;

/**
 * @todo
 */
class UserPrivateUserScope extends UserPrivateController
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
