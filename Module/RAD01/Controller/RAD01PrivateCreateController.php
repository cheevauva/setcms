<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\DAO\RAD01CreateDAO;
use Module\RAD01\View\RAD01PrivateCreateView;
use Module\RAD01\Mapper\RAD01FromRequestMapper;

class RAD01PrivateCreateController extends ControllerViaPSR7
{

    private RAD01Entity $rad01;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD01FromRequestMapper::class,
            RAD01CreateDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateCreateView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD01CreateDAO) {
            $object->rad01 = $this->rad01;
        }

        if ($object instanceof RAD01PrivateCreateView) {
            $object->rad01 = $this->rad01;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD01FromRequestMapper) {
            $this->rad01 = $object->rad01;
        }
    }
}
