<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\DAO\MenuUpdateDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\View\MenuPrivateUpdateView;
use Module\Menu\Exception\MenuParamsInvalidJsonException;

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
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menu = MenuEntity::as($object->menu);
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

        $params = $body->string('menu.params')->notEmpty()->val();
        
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

        if ($object instanceof MenuUpdateDAO) {
            $object->menu = $this->menu;
        }
        
        if ($object instanceof MenuPrivateUpdateView) {
            $object->menu = $this->menu;
        }
    }
}
