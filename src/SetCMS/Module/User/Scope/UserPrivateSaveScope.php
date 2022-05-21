<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Scope;

use SetCMS\Module\User\UserEntity;

class UserPrivateSaveScope extends \SetCMS\Entity\Scope\EntitySaveScope
{

    public string $role;

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
