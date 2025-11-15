<?php

declare(strict_types=1);

namespace SetCMS\ACL\Symbiont;

use SetCMS\ACL\VO\ACLRoleVO;
use SetCMS\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;

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
            $object->role = ACLRoleVO::as($master->ctx['currentUserRole'] ?? null);
        }
    }
}
