<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Servant;

use SetCMS\Module\Menu\Hook\MenuRetrieveActionsByContextHook;
use SetCMS\Module\Menu\MenuAction\Entity\MenuActionEntity;
use SetCMS\Module\Post\Scope\PostPublicReadBySlugScope;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\UUID;

class PostMenuActionsByRequestServant implements \SetCMS\Application\Contract\ContractServant, \SetCMS\Application\Contract\ContractApplicable
{

    use \SetCMS\Traits\DITrait;

    public UserEntity $currentUser;
    public array $actions = [];
    public mixed $context;

    public function serve(): void
    {
        $context = $this->context;

        if ($context instanceof PostPublicReadBySlugScope) {
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
        $retrieveBySlug = PostRetrieveBySlugDAO::make($this->factory());
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->serve();

        $editAction = new MenuActionEntity;
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'action_record_admin';
        $editAction->params = [
            'module' => 'Post',
            'action' => 'edit',
            'id' => $retrieveBySlug->post->id->uuid,
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

    public function from(object $object): void
    {
        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $this->currentUser = $object->currentUser;
            $this->context = $object->context;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof MenuRetrieveActionsByContextHook) {
            $object->actions = $this->actions;
        }
    }
}
