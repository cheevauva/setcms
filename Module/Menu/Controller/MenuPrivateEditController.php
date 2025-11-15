<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\UUID;
use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\Entity\MenuEntity;

class MenuPrivateEditController extends ControllerViaPSR7
{

    protected MenuEntity $menu;

    public UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuRetrieveManyByCriteriaDAO::class
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menu = MenuEntity::as($object->menu);
        }
    }
}
