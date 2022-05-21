<?php

namespace SetCMS\Module\User\Servant;

use SetCMS\Controller\Event\ScopeProtectionEvent;
use Psr\Container\ContainerInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\Scope;
use SetCMS\ACL;

class UserProtectScopeServant implements \SetCMS\ServantInterface
{

    private ACL $acl;
    public ?UserEntity $user = null;
    public Scope $scope;
    
    use \SetCMS\FactoryTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->acl = $container->get(ACL::class);
    }

    public function __invoke(...$params)
    {
        $event = ($params[0] ?? null);
        
        if ($event instanceof ScopeProtectionEvent) {
            $this->user = new UserEntity;//$event->request->getAttribute('user');
            $this->scope = $event->scope;
            $this->serve();
        }

        return $params;
    }

    public function serve(): void
    {
        if (empty($this->user) || empty($this->scope)) {
            throw new \RuntimeException('Потерян контекст текущего пользователя или выполняемоего действия');
        }

        if (!$this->acl->hasResource('scope')) {
            throw ModuleException::serverError(sprintf('Не найден ресурс %s', 'scope'));
        }

        if (!$this->acl->isAllowed($this->user->role, 'scope', get_class($this->scope))) {
            throw new \RuntimeException('Доступ запрещён');
        }
    }

}
