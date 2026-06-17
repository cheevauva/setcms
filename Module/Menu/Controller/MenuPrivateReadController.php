<?php

declare(strict_types=1);

namespace Module\Menu\Controller;

use SetCMS\UUID;
use Module\Menu\View\MenuPrivateReadView;
use Module\Menu\DAO\MenuRetrieveManyByCriteriaDAO;
use Module\Menu\Entity\MenuEntity;
use SetCMS\Mapper\MapperIdFromRequest;

class MenuPrivateReadController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected MenuEntity $menu;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            MapperIdFromRequest::class,
            MenuRetrieveManyByCriteriaDAO::class
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MenuPrivateReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
            $object->limit = 1;
        }

        if ($object instanceof MenuPrivateReadView) {
            $object->menu = $this->menu;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $this->menu = $object->menu;
        }

        if ($object instanceof MapperIdFromRequest) {
            $this->id = $object->id;
        }
    }
}
