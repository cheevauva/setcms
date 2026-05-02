<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Menu\DAO\MenuCreateDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\View\MenuPrivateCreateView;
use Module\Menu\Exception\MenuParamsInvalidJsonException;

class MenuPrivateCreateController extends ControllerViaPSR7
{

    protected MenuEntity $menu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuCreateDAO::class
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $body = $this->validationBody();
        $body->array('menu')->notEmpty()->validate();

        $params = $body->string('menu.params')->notEmpty()->val();

        if (!json_validate($params)) {
            $this->messages->attach(new MenuParamsInvalidJsonException('Невалидный json'), 'menu.params');
        }
        
        $this->menu = new MenuEntity();
        $this->menu->label = $body->string('menu.label')->notEmpty()->val();
        $this->menu->route = $body->string('menu.route')->notEmpty()->val();
        $this->menu->params = json_decode($params, true) ?? [];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuCreateDAO) {
            $this->menu = $object->menu;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuCreateDAO) {
            $object->menu = $this->menu;
        }

        if ($object instanceof MenuPrivateCreateView) {
            $object->menu = $this->menu;
        }
    }
}
