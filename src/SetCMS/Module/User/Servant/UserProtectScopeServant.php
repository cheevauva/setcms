<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Controller\Hook\ScopeProtectionHook;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\User\Exception\UserForbiddenException;
use SetCMS\Scope;
use SetCMS\ACL;

class UserProtectScopeServant implements ContractServant, ContractApplicable
{

    use \SetCMS\Traits\DITrait;
    use \SetCMS\Traits\FactoryTrait;

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
