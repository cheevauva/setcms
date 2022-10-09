<?php

namespace SetCMS\Module\User\Servant;

use SetCMS\Controller\Event\ScopeProtectionEvent;
use SetCMS\Module\User\UserEntity;
use SetCMS\Scope;
use SetCMS\ACL;
use SetCMS\ServerRequestAttribute;

class UserProtectScopeServant implements \SetCMS\ServantInterface, \SetCMS\Contract\Applicable
{

    use \SetCMS\DITrait;

    public UserEntity $user;
    public Scope $scope;

    use \SetCMS\FactoryTrait;

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
            throw new \RuntimeException('Доступ запрещён');
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof ScopeProtectionEvent) {
            $this->user = $object->request->getAttribute(ServerRequestAttribute::CURRENT_USER) ?? new UserEntity;
            $this->scope = $object->scope;
        }
    }

}
