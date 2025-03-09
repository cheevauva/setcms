<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\EventHandler;

use SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Module\User\Exception\UserForbiddenException;
use SetCMS\Module\User\Entity\UserEntity;

class ACLUserScopeProtectionEventHandler extends \UUA\EventHandler
{

    #[\Override]
    public function from(object $object): void
    {
        if ($object instanceof ScopeProtectionHook) {
            $master = ACLCheckByRoleAndPrivilegeServant::as($this->master);
            $master->role = UserEntity::as($object->user)->role->value;
            $master->throwExceptions = true;
            $master->privilege = get_class($object->scope);
        }
    }

    #[\Override]
    public function catch(\Throwable $object): void
    {
        throw new UserForbiddenException($object->getMessage());
    }
}
