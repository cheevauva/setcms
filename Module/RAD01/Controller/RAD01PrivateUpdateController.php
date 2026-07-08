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

    protected RAD01Entity $rad01;
    protected RAD01Entity $newRAD01;

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
            $object->id = $this->newRAD01->id;
        }

        if ($object instanceof RAD01UpdateDAO) {
            $object->rad01 = $this->rad01;
            $object->rad01->field01 = $this->newRAD01->field01;
        }

        if ($object instanceof RAD01PrivateUpdateView) {
            $object->rad01 = $this->rad01;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD01GetByIdServant) {
            $this->rad01 = $object->rad01;
        }

        if ($object instanceof RAD01FromRequestMapper) {
            $this->newRAD01 = $object->rad01;
        }
    }
}
