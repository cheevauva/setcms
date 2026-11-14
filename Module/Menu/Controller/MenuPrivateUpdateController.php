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

    protected MenuEntity $entity;
    protected MenuEntity $newEntity;

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
            $this->entity = $object->entity;
        }

        if ($object instanceof MenuFromRequestMapper) {
            $this->newEntity = $object->entity;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof MenuRetrieveManyByCriteriaDAO) {
            $object->id = $this->newEntity->id;
            $object->limit = 1;
            $object->expectOne = true;
            $object->allowEmptyResult = false;
        }

        if ($object instanceof MenuUpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->label = $this->newEntity->label;
            $object->entity->route = $this->newEntity->route;
            $object->entity->params = $this->newEntity->params;
        }

        if ($object instanceof MenuPrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }
}
