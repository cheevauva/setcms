<?php

namespace SetCMS\Module\User\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\Exception\UserForbiddenException;
use SetCMS\Scope;
use SetCMS\ACL;

class UserProtectScopeServant implements Servant, Applicable
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public UserEntity $user;
    public Scope $scope;

    public function serve(): void
    {
        $acl = ACL::make($this->container);

        if (empty($this->user) || empty($this->scope)) {
            throw new \RuntimeException('Потерян контекст текущего пользователя или выполняемоего действия');
        }

        if (!$acl->hasResource('scope')) {
            throw ModuleException::serverError(sprintf('Не найден ресурс %s', 'scope'));
        }

        if (!$acl->isAllowed($this->user->role->value, 'scope', get_class($this->scope))) {
            throw new UserForbiddenException;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof ScopeProtectionHook) {
            $this->user = $object->user ?? new UserEntity;
            $this->scope = $object->scope;
        }
    }

    public function to(object $object): void
    {
        
    }

}
