<?php

declare(strict_types=1);

namespace SetCMS\Module\Menu\Controller;

use SetCMS\Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use SetCMS\Module\Menu\DAO\MenuSaveDAO;
use SetCMS\Module\Menu\Entity\MenuEntity;
use SetCMS\Module\Menu\View\MenuPrivateUpdateView;
use SetCMS\Module\Menu\Exception\MenuParamsInvalidJsonException;

class MenuPrivateUpdateController extends \SetCMS\ControllerViaPSR7
{

    protected MenuEntity $menu;
    protected MenuEntity $newMenu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyByCriteriaDAO::class,
            MenuSaveDAO::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menu = MenuEntity::as($object->menu);
        }
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newMenu = new MenuEntity();
        $this->newMenu->id = $validation->uuid('menu.id')->notEmpty()->val();
        $this->newMenu->route = $validation->string('menu.route')->notEmpty()->val();
        $this->newMenu->label = $validation->string('menu.label')->notEmpty()->val();

        $params = $validation->string('menu.params')->notEmpty()->val();
        
        if (!json_validate($params)) {
            throw new MenuParamsInvalidJsonException('Невалидный json');
        }
         
        $this->newMenu->params = json_decode($params, true) ?? [];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->id = $this->newMenu->id;
        }

        if ($object instanceof MenuSaveDAO) {
            $object->menu = $this->menu;
        }
        
        if ($object instanceof MenuPrivateUpdateView) {
            $object->menu = $this->menu;
        }
    }
}
