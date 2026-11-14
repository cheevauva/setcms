<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\UUID;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Servant\RAD01GetByIdServant;
use Module\RAD01\DAO\RAD01DeleteByIdDAO;
use Module\RAD01\View\RAD01PrivateDeleteView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class RAD01PrivateDeleteController extends ControllerViaPSR7
{

    public RAD01Entity $entity;
    public UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            RAD01GetByIdServant::class,
            RAD01DeleteByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateDeleteView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD01GetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof RAD01PrivateDeleteView) {
            $object->entity = $this->entity;
        }

        if ($object instanceof RAD01DeleteByIdDAO) {
            $object->id = $this->entity->id;
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
