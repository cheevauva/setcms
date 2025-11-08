<?php

declare(strict_types=1);

namespace SetCMS\Module\ACL\Servant;

use SetCMS\ACL;

class ACLCheckByRoleAndPrivilegeServant extends \UUA\Servant
{

    public bool $skip = false;
    public public(set) string|\Closure $role;
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

        $role = $this->role;

        if ($role instanceof \Closure) {
            $role = $role();
        }

        if (!$acl->hasResource('routes')) {
            throw new \RuntimeException(sprintf('Не найден ресурс "routes"'));
        }


        if (!$acl->isAllowed($role, 'routes', $this->privilege)) {
            throw new \RuntimeException(sprintf('Для роли "%s" не разрешен доступ к привелегии "%s" ресурса "routes"', $role, $this->privilege));
        }
    }
}
