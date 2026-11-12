<?php

declare(strict_types=1);

namespace Module\Menu\MenuAction\Servant;

use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\ACL\VO\ACLRoleVO;
use Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Router\Exception\RouterNotFoundException;
use SetCMS\Router\RouterMatchDTO;

abstract class MenuActionsByRequestServant extends \UUA\Servant
{

    use \SetCMS\Traits\TraitsRouter;

    /**
     * @var MenuActionEntity[]
     */
    public protected(set) array $actions;
    public string $path;
    public string $queryParams;
    public ACLRoleVO $role;
    protected RouterMatchDTO $route;

    protected function hasAccess(string $route): bool
    {
        return ACLCheckByRoleAndPrivilegeServant::call($this, $this->role, $route)->isAllow;
    }

    #[\Override]
    protected function run(): void
    {
        $this->actions = [];

        try {
            $this->route = $this->router()->match($this->path, 'GET');
        } catch (RouterNotFoundException $ex) {
            $this->route = new RouterMatchDTO;
            $this->route->name = '';
            $this->route->target = '';
            $this->route->params = [];
        }

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
