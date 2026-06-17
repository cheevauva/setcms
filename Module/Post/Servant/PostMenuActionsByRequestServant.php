<?php

declare(strict_types=1);

namespace Module\Post\Servant;

use SetCMS\UUID;
use SetCMS\UseCase\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;
use SetCMS\UseCase\ACL\VO\ACLRoleVO;
use Module\Menu\MenuAction\Entity\MenuActionEntity;
use Module\Post\View\PostPublicReadBySlugView;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Responder;
use SetCMS\View\View;

class PostMenuActionsByRequestServant extends \UUA\Servant
{

    /**
     * @var MenuActionEntity[]
     */
    public protected(set) array $actions;
    public View|Responder $view;
    public ACLRoleVO $role;

    #[\Override]
    public function serve(): void
    {
        $this->actions = [];

        $view = $this->view;

        if ($view instanceof PostPublicReadBySlugView) {
            $this->actions[] = $this->prepareEditAction($view->post->slug);
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
        $indexAction->label = 'Список постов';
        $indexAction->route = 'AdminPostIndex';

        return $indexAction;
    }

    private function prepareEditAction(string $slug): MenuActionEntity
    {
        $retrieveBySlug = PostRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->limit = 1;
        $retrieveBySlug->allowEmptyResult = false;
        $retrieveBySlug->expectOne = true;
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity();
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'AdminPostEdit';
        $editAction->params = [
            'id' => $retrieveBySlug->post->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity();
        $createAction->label = 'Создать пост';
        $createAction->route = 'AdminPostNew';
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
