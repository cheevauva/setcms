<?php

declare(strict_types=1);

namespace Module\Post\MenuAction\Servant;

use SetCMS\UUID;
use Module\Post\Controller\PostPublicReadBySlugController;
use Module\Post\DAO\PostRetrieveManyByCriteriaDAO;

class PostMenuActionsByRequestServant extends \Module\Menu\MenuAction\Servant\MenuActionsByRequestServant
{

    protected function prepareIndexAction(): void
    {
        $indexAction = $this->menuAction();
        $indexAction->label = 'Список постов';
        $indexAction->route = 'AdminPostIndex';
    }

    protected function prepareEditAction(string $slug): void
    {
        $retrieveBySlug = PostRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveBySlug->slug = $slug;
        $retrieveBySlug->limit = 1;
        $retrieveBySlug->allowEmptyResult = false;
        $retrieveBySlug->expectOne = true;
        $retrieveBySlug->serve();

        $editAction = $this->menuAction();
        $editAction->label = 'Редактировать пост';
        $editAction->route = 'AdminPostEdit';
        $editAction->params = [
            'id' => $retrieveBySlug->entity->id->uuid,
        ];
    }

    protected function prepareCreateAction(): void
    {
        $createAction = $this->menuAction();
        $createAction->label = 'Создать пост';
        $createAction->route = 'AdminPostNew';
        $createAction->params = [
            'id' => new UUID()->uuid,
        ];
    }

    #[\Override]
    protected function prepareMenuActions(): void
    {
        if ($this->route->target === PostPublicReadBySlugController::class) {
            $this->prepareEditAction($this->route->params['slug']);
        }

        $this->prepareIndexAction();
        $this->prepareCreateAction();
    }
}
