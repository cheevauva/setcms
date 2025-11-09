<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\Symbiont;

use SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;
use SetCMS\Module\User\Exception\UserForbiddenException;

class ACLUserScopeProtectionSymbiont extends \UUA\SymbiontCustomizer
{

    #[\Override]
    public function to(object $object): void
    {
        if ($object instanceof ACLCheckByRoleAndPrivilegeServant) {
            $master = ControllerOnBeforeServeEvent::as($this->master);
            //
            $object->throwExceptions = true;
            $object->skip = !$master->controller->hasACLCheck;
            $object->privilege = $master->route;
            $object->role = $master->ctx['currentUserRole'];
        }
    }

    #[\Override]
    public function catch(\Throwable $object): void
    {
        throw new UserForbiddenException($object->getMessage());
    }
}
