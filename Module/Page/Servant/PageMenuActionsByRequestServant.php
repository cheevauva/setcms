<?php

declare(strict_types=1);

namespace Module\Page\Servant;

use SetCMS\UUID;
use Module\Page\View\PagePublicReadView;
use Module\Page\DAO\PageGetBySlugDAO;

class PageMenuActionsByRequestServant extends \Module\Menu\Servant\MenuActionsByRequestServant
{

    protected function prepareIndexAction(): void
    {
        $indexAction = $this->menuAction();
        $indexAction->label = 'Список страниц';
        $indexAction->route = 'AdminPageIndex';
    }

    protected function prepareEditAction(string $slug): void
    {
        $getBySlug = PageGetBySlugDAO::new($this->container);
        $getBySlug->slug = $slug;
        $getBySlug->serve();

        $editAction = $this->menuAction();
        $editAction->label = 'Редактировать страницу';
        $editAction->route = 'AdminPageEdit';
        $editAction->params = [
            'id' => $getBySlug->page->id->uuid,
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
        $view = $this->view;

        if ($view instanceof PagePublicReadView) {
            $this->prepareEditAction($view->page->slug);
        }

        $this->prepareIndexAction();
        $this->prepareCreateAction();
    }
}
