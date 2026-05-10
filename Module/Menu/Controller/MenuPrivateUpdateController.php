<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\DAO\MenuUpdateDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\View\MenuPrivateUpdateView;

class MenuPrivateUpdateController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected MenuEntity $menu;
    protected MenuEntity $newMenu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
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
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $body = $this->validationBody();

        $this->newMenu = new MenuEntity();
        $this->newMenu->id = $body->uuid('menu.id')->notEmpty()->val();
        $this->newMenu->route = $body->string('menu.route')->notEmpty()->val();
        $this->newMenu->label = $body->string('menu.label')->notEmpty()->val();
        $this->newMenu->params = $body->json('menu.params')->notEmpty()->asArray()->val();
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
