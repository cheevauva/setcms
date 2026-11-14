<?php

declare(strict_types=1);

namespace Module\Page\MenuAction\Servant;

use SetCMS\UUID;
use Module\Page\Controller\PagePublicReadBySlugController;
use Module\Page\DAO\PageGetBySlugDAO;

class PageMenuActionsByRequestServant extends \Module\Menu\MenuAction\Servant\MenuActionsByRequestServant
{

    protected function prepareIndexAction(): void
    {
        $indexAction = $this->menuAction();
        $indexAction->label = 'Список страниц';
        $indexAction->route = 'AdminPageIndex';
    }

    protected function prepareEditAction(string $slug): void
    {
        $getBySlug = PageGetBySlugDAO::new($this);
        $getBySlug->slug = $slug;
        $getBySlug->serve();

        $editAction = $this->menuAction();
        $editAction->label = 'Редактировать страницу';
        $editAction->route = 'AdminPageEdit';
        $editAction->params = [
            'id' => $getBySlug->entity->id->uuid,
        ];
    }

    protected function prepareCreateAction(): void
    {
        $createAction = $this->menuAction();
        $createAction->label = 'Создать страницу';
        $createAction->route = 'AdminPageNew';
        $createAction->params = [
            'id' => new UUID()->uuid,
        ];
    }

    #[\Override]
    protected function prepareMenuActions(): void
    {
        if ($this->route->target === PagePublicReadBySlugController::class) {
            $this->prepareEditAction($this->route->params['slug']);
        }

        $this->prepareIndexAction();
        $this->prepareCreateAction();
    }
}
