<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\View\PostPublicReadBySlugView;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\UUID;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Application\Router\Router;
use SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant;

class PostMenuActionsByRequestServant extends \UUA\Servant
{

    /**
     * @var MenuActionEntity[]
     */
    public array $actions = [];

    /**
     * @var array<string, mixed>
     */
    public array $ctx;

    #[\Override]
    public function serve(): void
    {
        $view = $this->ctx['view'] ?? null;

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
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity();
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'AdminPostEdit';
        $editAction->params = [
            'id' => PostEntity::as($retrieveBySlug->post)->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity();
        $createAction->label = 'Создать пост';
        $createAction->route = 'AdminPostNew';
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
