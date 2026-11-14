<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Servant\RAD01GetByIdServant;
use Module\RAD01\DAO\RAD01UpdateDAO;
use Module\RAD01\View\RAD01PrivateUpdateView;
use Module\RAD01\Mapper\RAD01FromRequestMapper;

class RAD01PrivateUpdateController extends ControllerViaPSR7
{

    protected RAD01Entity $entity;
    protected RAD01Entity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD01FromRequestMapper::class,
            RAD01GetByIdServant::class,
            RAD01UpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD01GetByIdServant) {
            $object->id = $this->newEntity->id;
        }

        if ($object instanceof RAD01UpdateDAO) {
            $object->entity = $this->entity;
            $object->entity->field01 = $this->newEntity->field01;
        }

        if ($object instanceof RAD01PrivateUpdateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD01GetByIdServant) {
            $this->entity = $object->entity;
        }

        if ($object instanceof RAD01FromRequestMapper) {
            $this->newEntity = $object->entity;
        }
    }
}
