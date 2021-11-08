<?php

namespace SetCMS\Module\Users\UserEvent;

use SetCMS\Event\FrontControllerBeforeLaunchActionEvent as Event;
use SetCMS\Module\Modules\ModuleException;
use SetCMS\Module\Users\User;
use SetCMS\ACL;
use Laminas\Permissions\Acl\Exception\InvalidArgumentException;

class VerifyAccessEventHandler
{

    private ACL $acl;

    public function __construct(ACL $acl)
    {
        $this->acl = $acl;
    }

    public function __invoke(Event $event): Event
    {
        $currentUser = $event->request->getAttribute('user');
        $action = $event->action;

        if (!$currentUser || !$action) {
            throw ModuleException::serverError('Потерян контекст текущего пользователя или выполняемоего действия');
        }

        if (!($currentUser instanceof User)) {
            throw ModuleException::serverError(sprintf('Объект пользователя не является классом %s', User::class));
        }

        list($resource, $rule) = $action->getResourceRule();


        if (!$this->acl->hasResource($resource)) {
            throw ModuleException::serverError(sprintf('Не найден ресурс %s', $resource));
        }
        
        if (!$this->acl->isAllowed($currentUser->role, $resource, $rule)) {
            throw ModuleException::notAllow();
        }

        return $event;
    }

}
