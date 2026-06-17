<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Servant\Entity01GetByIdServant;
use Module\Module01\DAO\Entity01UpdateDAO;
use Module\Module01\View\Entity01PrivateUpdateView;
use Module\Module01\Mapper\Entity01FromRequestMapper;

class Entity01PrivateUpdateController extends ControllerViaPSR7
{

    protected Entity01Entity $entity01;
    protected Entity01Entity $newEntity01;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01FromRequestMapper::class,
            Entity01GetByIdServant::class,
            Entity01UpdateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateUpdateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01GetByIdServant) {
            $object->id = $this->newEntity01->id;
        }

        if ($object instanceof Entity01UpdateDAO) {
            $object->entity01 = $this->entity01;
            $object->entity01->field01 = $this->newEntity01->field01;
        }

        if ($object instanceof Entity01PrivateUpdateView) {
            $object->entity01 = $this->entity01;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01GetByIdServant) {
            $this->entity01 = $object->entity01;
        }

        if ($object instanceof Entity01FromRequestMapper) {
            $this->newEntity01 = $object->entity01;
        }
    }
}
