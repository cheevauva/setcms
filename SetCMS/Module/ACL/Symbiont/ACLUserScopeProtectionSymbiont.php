<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\Symbiont;

use SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Module\User\Exception\UserForbiddenException;
use SetCMS\Module\User\Entity\UserEntity;

class ACLUserScopeProtectionSymbiont extends \UUA\SymbiontCustomizer
{

    #[\Override]
    public function to(object $object): void
    {
        if ($object instanceof ACLCheckByRoleAndPrivilegeServant) {
            $master = ControllerOnBeforeServeEvent::as($this->master);
            $object->role = UserEntity::as($master->request->getAttribute('currentUser'))->role->value;
            $object->throwExceptions = true;
            $object->privilege = $master->route;
        }
    }

    #[\Override]
    public function catch(\Throwable $object): void
    {
        throw new UserForbiddenException($object->getMessage());
    }
}
