<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\DAO\MenuUpdateDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\View\MenuPrivateUpdateView;
use Module\Menu\Mapper\MenuFromRequestMapper;

class MenuPrivateUpdateController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected MenuEntity $menu;
    protected MenuEntity $newMenu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuFromRequestMapper::class,
            MenuRetrieveManyByCriteriaDAO::class,
            MenuUpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menu = $object->menu;
        }

        if ($object instanceof MenuFromRequestMapper) {
            $this->newMenu = $object->menu;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->id = $this->newMenu->id;
            $object->limit = 1;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
        }

        if ($object instanceof MenuUpdateDAO) {
            $object->menu = $this->menu;
            $object->menu->label = $this->newMenu->label;
            $object->menu->route = $this->newMenu->route;
            $object->menu->params = $this->newMenu->params;
        }

        if ($object instanceof MenuPrivateUpdateView) {
            $object->menu = $this->menu;
        }
    }
}
