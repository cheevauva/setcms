<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\Servant;

use SetCMS\ACL;

class ACLCheckByRoleAndPrivilegeServant extends \UUA\Servant
{

    public public(set)string $role;
    public public(set) string $privilege;
    public protected(set) bool $isAllow = false;
    public public(set) bool $throwExceptions = false;
    public protected(set) ?\Throwable $exception = null;

    public function serve(): void
    {
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

        if (!$acl->hasResource('scope')) {
            throw new \RuntimeException(sprintf('Не найден ресурс "scope"'));
        }

        if (!$acl->isAllowed($this->role, 'scope', $this->privilege)) {
            throw new \RuntimeException(sprintf('Для роли "%s" не разрешен доступ к привелегии "%s" ресурса "scope"', $this->role, $this->privilege));
        }
    }
}
