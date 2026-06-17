<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\UUID;
use SetCMS\UseCase\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;
use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\Page\View\PagePublicReadView;
use Module\Page\DAO\PageGetBySlugDAO;
use SetCMS\Responder;
use SetCMS\View\View;

class PageMenuActionsByRequestServant extends \UUA\Servant
{

    /**
     * @var MenuActionEntity[]
     */
    public protected(set) array $actions;
    public View|Responder $view;
    public ACLRoleVO $role;

    public function serve(): void
    {
        $this->actions = [];

        $view = $this->view;

        if ($view instanceof PagePublicReadView) {
            $this->actions[] = $this->prepareEditAction($view->page->slug);
        }

        $this->actions[] = $this->prepareIndexAction();
        $this->actions[] = $this->prepareCreateAction();

        foreach ($this->actions as $index => $action) {
            if (!$this->hasAccess($action->route)) {
                unset($this->actions[$index]);
            }
        }
    }

    private function prepareIndexAction(): MenuActionEntity
    {
        $indexAction = new MenuActionEntity();
        $indexAction->label = 'Список страниц';
        $indexAction->route = 'AdminPageIndex';

        return $indexAction;
    }

    private function prepareEditAction(string $slug): MenuActionEntity
    {
        $getBySlug = PageGetBySlugDAO::new($this->container);
        $getBySlug->slug = $slug;
        $getBySlug->serve();

        $editAction = new MenuActionEntity();
        $editAction->label = 'Редактировать страницу';
        $editAction->route = 'AdminPageEdit';
        $editAction->params = [
            'id' => $getBySlug->page->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity();
        $createAction->label = 'Создать страницу';
        $createAction->route = 'AdminPageNew';
        $createAction->params = [
            'id' => new UUID()->uuid,
        ];

        return $createAction;
    }

    protected function hasAccess(string $route): bool
    {
        return ACLCheckByRoleAndPrivilegeServant::call($this->container, $this->role, $route)->isAllow;
    }
}
