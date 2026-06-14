<?php

declare(strict_types=1);

namespace SetCMS\UseCase\ACL\Servant;

use SetCMS\Controller\Controller;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;
use SetCMS\UseCase\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\UseCase\ACL\Exception\ACLNotAllowException;
use SetCMS\Controller\Event\ControllerOnBeforeServeEvent;

class ACLControllerServant extends \UUA\Servant
{

    public Controller $controller;

    #[\Override]
    public function serve(): void
    {
        $controller = $this->controller;
        $role = ACLRoleVO::as($controller->ctx['currentUserRole'] ?? null);
        $privilege = $controller->name;

        if (!ACLCheckByRoleAndPrivilegeServant::call($this->container, $role, $privilege)->isAllow) {
            throw new ACLNotAllowException((string) $role, $privilege);
        }
    }

    public function __invoke(object $object): void
    {
        if ($object instanceof ControllerOnBeforeServeEvent) {
            $this->controller = $object->controller;
        }
        
    }
}
