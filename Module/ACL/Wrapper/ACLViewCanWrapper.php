<?php

declare(strict_types=1);

namespace Module\ACL\Wrapper;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\ViewHtml;
use Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use Module\ACL\VO\ACLRoleVO;

class ACLViewCanWrapper extends \UUA\Wrapper
{

    #[\Override]
    protected function onAfter(): void
    {
        
    }

    #[\Override]
    protected function onBefore(): void
    {
        $root = ViewHtml::as($this->rootUnit);
        $root->withAttr('can', fn() => $this->can(...));
    }

    protected function can(ServerRequestInterface $request, string $privilege): bool
    {
        return ACLCheckByRoleAndPrivilegeServant::call($this, ACLRoleVO::as($request->getAttribute('currentUserRole')), $privilege)->isAllow;
    }
}
