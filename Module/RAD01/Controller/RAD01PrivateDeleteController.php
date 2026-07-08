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

    public RAD01Entity $rad01;
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
            $object->rad01 = $this->rad01;
        }

        if ($object instanceof RAD01DeleteByIdDAO) {
            $object->id = $this->rad01->id;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD01GetByIdServant) {
            $this->rad01 = $object->rad01;
        }
        
        if ($object instanceof RequestToIdMapper) {
            $this->id = $object->id;
        }
    }
}
