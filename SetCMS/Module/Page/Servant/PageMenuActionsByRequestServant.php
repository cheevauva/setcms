<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Servant;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Page\View\PagePublicReadView;
use SetCMS\Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use SetCMS\UUID;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\Application\Router\Router;

class PageMenuActionsByRequestServant extends \UUA\Servant
{

    /**
     * @var MenuActionEntity[]
     */
    public array $actions = [];

    /**
     * @var array<string, mixed>
     */
    public array $ctx;

    public function serve(): void
    {
        $view = $this->ctx['view'] ?? null;

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
        $retrieveBySlug = PageRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity();
        $editAction->label = 'Редактировать страницу';
        $editAction->route = 'AdminPageEdit';
        $editAction->params = [
            'id' => PageEntity::as($retrieveBySlug->page)->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity();
        $createAction->label = 'Создать страницу';
        $createAction->route = 'AdminPageNew';
        $createAction->params = [
            'id' => new UUID(),
        ];

        return $createAction;
    }

    protected function hasAccess(string $route): bool
    {
        $checkRole = ACLCheckByRoleAndPrivilegeServant::new($this->container);
        $checkRole->role = UserEntity::as($this->ctx['currentUser'])->role->value;
        $checkRole->throwExceptions = false;
        $checkRole->privilege = Router::singleton($this->container)->controllerByRoute($route);
        $checkRole->serve();

        return $checkRole->isAllow;
    }
}
