<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Servant\RAD99GetByIdServant;
use Module\RAD99\DAO\RAD99UpdateDAO;
use Module\RAD99\View\RAD99PrivateUpdateView;
use Module\RAD99\Mapper\RAD99FromRequestMapper;

class RAD99PrivateUpdateController extends ControllerViaPSR7
{

    protected RAD99Entity $entity;
    protected RAD99Entity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD99FromRequestMapper::class,
            RAD99GetByIdServant::class,
            RAD99UpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD99GetByIdServant) {
            $object->id = $this->newEntity->id;
        }

        if ($object instanceof RAD99UpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->field99 = $this->newEntity->field99;
        }

        if ($object instanceof RAD99PrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD99GetByIdServant) {
            $this->entity = $object->entity;
        }

        if ($object instanceof RAD99FromRequestMapper) {
            $this->newEntity = $object->entity;
        }
    }
}
