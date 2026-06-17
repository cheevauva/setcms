<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Menu\DAO\MenuCreateDAO;
use Module\Menu\Entity\MenuEntity;
use Module\Menu\View\MenuPrivateCreateView;
use Module\Menu\Mapper\MenuFromRequestMapper;

class MenuPrivateCreateController extends ControllerViaPSR7
{

    protected MenuEntity $menu;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MenuFromRequestMapper::class,
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
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuFromRequestMapper) {
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
