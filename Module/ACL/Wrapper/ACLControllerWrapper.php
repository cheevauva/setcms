<?php

declare(strict_types=1);

namespace Module\ACL\Wrapper;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\Router\RouterRouteDTO;
use Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use Module\ACL\Exception\ACLNotAllowException;
use Module\ACL\VO\ACLRoleVO;

class ACLControllerWrapper extends \UUA\Wrapper
{

    #[\Override]
    protected function onAfter(): void
    {
        
    }

    #[\Override]
    protected function onBefore(): void
    {
        $controller = ControllerViaPSR7::as($this->rootUnit);
        
        if ($controller->attr('skipACL')) { 
            return;
        }
        
        $role = ACLRoleVO::as($controller->request->getAttribute('currentUserRole'));
        $privilege = RouterRouteDTO::fromRequest($controller->request)->name;

        if (!ACLCheckByRoleAndPrivilegeServant::call($this, $role, $privilege)->isAllow) {
            throw new ACLNotAllowException((string) $role, $privilege);
        }
    }
}
