<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\View\PostPublicReadBySlugView;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\UUID;
use SetCMS\Module\User\Entity\UserEntity;

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
        $currentUser = UserEntity::as($this->ctx['currentUser']);
        $view = $this->ctx['view'] ?? null;

        if ($view instanceof PostPublicReadBySlugView) {
            if ($currentUser->isAdmin()) {
                $this->actions[] = $this->prepareEditAction($view->post->slug);
            }
        }

        if ($currentUser->isAdmin()) {
            $this->actions[] = $this->prepareIndexAction();
            $this->actions[] = $this->prepareCreateAction();
        }
    }

    private function prepareIndexAction(): MenuActionEntity
    {
        $indexAction = new MenuActionEntity();
        $indexAction->label = 'Список постов';
        $indexAction->route = 'action_admin';
        $indexAction->params = [
            'module' => 'Post',
            'action' => 'index',
        ];

        return $indexAction;
    }

    private function prepareEditAction(string $slug): MenuActionEntity
    {
        $retrieveBySlug = PostRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity();
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'action_record_admin';
        $editAction->params = [
            'module' => 'Post',
            'action' => 'edit',
            'id' => PostEntity::as($retrieveBySlug->post)->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity();
        $createAction->label = 'Создать пост';
        $createAction->route = 'action_record_admin';
        $createAction->params = [
            'module' => 'Post',
            'action' => 'new',
            'id' => new UUID(),
        ];

        return $createAction;
    }
}
