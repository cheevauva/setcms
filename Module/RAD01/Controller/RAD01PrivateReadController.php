<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Servant\RAD01GetByIdServant;
use Module\RAD01\View\RAD01PrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class RAD01PrivateReadController extends ControllerViaPSR7
{

    protected RAD01Entity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            RAD01GetByIdServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD01GetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof RAD01PrivateReadView) {
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

        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
