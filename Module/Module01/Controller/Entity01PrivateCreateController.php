<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\View\Entity01PrivateCreateView;
use Module\Module01\Mapper\Entity01FromRequestMapper;

class Entity01PrivateCreateController extends ControllerViaPSR7
{

    private Entity01Entity $entity01;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01FromRequestMapper::class,
            Entity01CreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateCreateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01CreateDAO) {
            $object->entity01 = $this->entity01;
        }

        if ($object instanceof Entity01PrivateCreateView) {
            $object->entity01 = $this->entity01;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01FromRequestMapper) {
            $this->entity01 = $object->entity01;
        }
    }
}
