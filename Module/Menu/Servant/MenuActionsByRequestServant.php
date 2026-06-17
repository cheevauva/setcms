<?php

declare(strict_types=1);

namespace Module\Menu\Servant;

use Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;
use SetCMS\Responder;
use SetCMS\View\View;
use SetCMS\UseCase\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;

abstract class MenuActionsByRequestServant extends \UUA\Servant
{

    /**
     * @var MenuActionEntity[]
     */
    public protected(set) array $actions;
    public View|Responder $view;
    public ACLRoleVO $role;

    protected function hasAccess(string $route): bool
    {
        return ACLCheckByRoleAndPrivilegeServant::call($this->container, $this->role, $route)->isAllow;
    }

    #[\Override]
    public function serve(): void
    {
        $this->actions = [];

        $this->prepareMenuActions();

        foreach ($this->actions as $index => $action) {
            $action = MenuActionEntity::as($action);
            
            if (!$this->hasAccess($action->route)) {
                unset($this->actions[$index]);
            }
        }
    }
    
    abstract protected function prepareMenuActions(): void;

    protected function menuAction(): MenuActionEntity
    {


        return $this->actions[] = new MenuActionEntity();
    }
}
