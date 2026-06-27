<?php

declare(strict_types=1);

namespace Module\Post\MenuAction\Servant;

use SetCMS\UUID;
use Module\Post\View\PostPublicReadBySlugView;
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
            'id' => $retrieveBySlug->post->id->uuid,
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
        $view = $this->view;

        if ($view instanceof PostPublicReadBySlugView) {
            $this->prepareEditAction($view->post->slug);
        }

        $this->prepareIndexAction();
        $this->prepareCreateAction();
    }
}
