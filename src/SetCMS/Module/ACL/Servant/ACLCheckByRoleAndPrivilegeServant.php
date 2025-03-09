<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\Servant;

use SetCMS\ACL;

class ACLCheckByRoleAndPrivilegeServant extends \UUA\Servant
{

    public string $role;
    public string $privilege;
    public bool $isAllow = false;
    public bool $throwExceptions = false;
    public ?\Throwable $exception = null;

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
