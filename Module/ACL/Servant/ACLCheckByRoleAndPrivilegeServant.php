<?php

declare(strict_types=1);

namespace Module\ACL\Servant;

use Psr\Container\ContainerInterface;
use UUA\WithContainterInterface;
use Module\ACL\ACL;
use Module\ACL\VO\ACLRoleVO;

class ACLCheckByRoleAndPrivilegeServant extends \UUA\Servant
{

    public public(set) ACLRoleVO $role;
    public public(set) string $privilege;
    public protected(set) bool $isAllow = false;
    public protected(set) ?\Throwable $exception = null;

    #[\Override]
    protected function run(): void
    {
        $acl = ACL::singleton($this->container);

        if (!$acl->hasResource('routes')) {
            throw new \RuntimeException(sprintf('Не найден ресурс "routes"'));
        }

        $this->isAllow = $acl->isAllowed((string) $this->role, 'routes', $this->privilege);
    }

    public static function call(WithContainterInterface|ContainerInterface $container, ACLRoleVO $role, string $privilege): self
    {
        $self = self::new($container);
        $self->role = $role;
        $self->privilege = $privilege;
        $self->serve();

        return $self;
    }
}
