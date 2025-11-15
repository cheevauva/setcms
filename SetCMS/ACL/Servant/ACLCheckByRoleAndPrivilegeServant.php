<?php

declare(strict_types=1);

namespace SetCMS\ACL\Servant;

use SetCMS\ACL\ACL;
use SetCMS\ACL\Exception\ACLNotAllowException;
use SetCMS\ACL\VO\ACLRoleVO;

class ACLCheckByRoleAndPrivilegeServant extends \UUA\Servant
{

    public bool $skip = false;
    public public(set) ACLRoleVO $role;
    public public(set) string $privilege;
    public protected(set) bool $isAllow = false;
    public public(set) bool $throwExceptions = false;
    public protected(set) ?\Throwable $exception = null;

    public function serve(): void
    {
        if ($this->skip) {
            $this->isAllow = true;
            return;
        }

        try {
            $this->process();
            $this->isAllow = true;
        } catch (\Exception $ex) {
            $this->isAllow = false;
            $this->exception = $ex;

            if ($this->throwExceptions) {
                throw $ex;
            }
        }
    }

    protected function process(): void
    {
        $acl = ACL::singleton($this->container);

        if (!$acl->hasResource('routes')) {
            throw new \RuntimeException(sprintf('Не найден ресурс "routes"'));
        }


        if (!$acl->isAllowed((string) $this->role, 'routes', $this->privilege)) {
            throw new ACLNotAllowException((string) $this->role, $this->privilege);
        }
    }
}
