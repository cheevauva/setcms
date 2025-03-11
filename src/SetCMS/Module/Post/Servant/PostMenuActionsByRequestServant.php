<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\Controller\PostPublicReadBySlugController;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\UUID;

class PostMenuActionsByRequestServant extends \UUA\Servant
{

    public UserEntity $currentUser;
    public array $actions = [];
    public mixed $context;

    public function serve(): void
    {
        $context = $this->context;

        if ($context instanceof PostPublicReadBySlugController) {
            if ($this->currentUser->isAdmin()) {
                $this->actions[] = $this->prepareEditAction($context->slug);
            }
        }

        if ($this->currentUser->isAdmin()) {
            $this->actions[] = $this->prepareIndexAction();
            $this->actions[] = $this->prepareCreateAction();
        }
    }

    private function prepareIndexAction(): MenuActionEntity
    {
        $indexAction = new MenuActionEntity;
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

        $editAction = new MenuActionEntity;
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'action_record_admin';
        $editAction->params = [
            'module' => 'Post',
            'action' => 'edit',
            'id' => $retrieveBySlug->first->id->uuid,
        ];

        return $editAction;
    }

    private function prepareCreateAction(): MenuActionEntity
    {
        $createAction = new MenuActionEntity;
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
