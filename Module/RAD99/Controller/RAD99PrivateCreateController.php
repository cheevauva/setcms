<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\DAO\RAD99CreateDAO;
use Module\RAD99\View\RAD99PrivateCreateView;
use Module\RAD99\Mapper\RAD99FromRequestMapper;

class RAD99PrivateCreateController extends ControllerViaPSR7
{

    protected RAD99Entity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD99FromRequestMapper::class,
            RAD99CreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateCreateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD99CreateDAO) {
            $object->entity = $this->entity;
        }

        if ($object instanceof RAD99PrivateCreateView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD99FromRequestMapper) {
            $this->entity = $object->entity;
        }
    }
}
