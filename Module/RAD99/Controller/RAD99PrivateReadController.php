<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Servant\RAD99GetByIdServant;
use Module\RAD99\View\RAD99PrivateReadView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class RAD99PrivateReadController extends ControllerViaPSR7
{

    protected RAD99Entity $rad99;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            RAD99GetByIdServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateReadView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD99GetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof RAD99PrivateReadView) {
            $object->rad99 = $this->rad99;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD99GetByIdServant) {
            $this->rad99 = $object->rad99;
        }

        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
