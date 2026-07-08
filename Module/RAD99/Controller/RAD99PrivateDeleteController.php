<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\UUID;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Servant\RAD99GetByIdServant;
use Module\RAD99\DAO\RAD99DeleteByIdDAO;
use Module\RAD99\View\RAD99PrivateDeleteView;
use SetCMS\Request\Mapper\RequestToIdMapper;

class RAD99PrivateDeleteController extends ControllerViaPSR7
{

    public RAD99Entity $rad99;
    public UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RequestToIdMapper::class,
            RAD99GetByIdServant::class,
            RAD99DeleteByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateDeleteView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof RAD99GetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof RAD99PrivateDeleteView) {
            $object->rad99 = $this->rad99;
        }

        if ($object instanceof RAD99DeleteByIdDAO) {
            $object->id = $this->rad99->id;
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
