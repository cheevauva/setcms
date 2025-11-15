<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Menu\DAO\MenuSaveDAO;
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
            MenuSaveDAO::class
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
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());
        $validation->array('menu')->notEmpty()->validate();

        $params = $validation->string('menu.params')->notEmpty()->val();

        if (!json_validate($params)) {
            $this->messages->attach(new MenuParamsInvalidJsonException('Невалидный json'), 'menu.params');
        }
        
        $this->menu = new MenuEntity();
        $this->menu->label = $validation->string('menu.label')->notEmpty()->val();
        $this->menu->route = $validation->string('menu.route')->notEmpty()->val();
        $this->menu->params = json_decode($params, true) ?? [];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuSaveDAO) {
            $this->menu = $object->menu;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuSaveDAO) {
            $object->menu = $this->menu;
        }

        if ($object instanceof MenuPrivateCreateView) {
            $object->menu = $this->menu;
        }
    }
}
