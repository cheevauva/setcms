<?php

declare(strict_types=1);

namespace Module\RAD01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD01\DAO\RAD01RetrieveByCriteriaDAO;
use Module\RAD01\View\RAD01PrivateIndexView;
use Module\RAD01\Entity\RAD01Entity;

class RAD01PrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var RAD01Entity[]
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD01RetrieveByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD01PrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD01RetrieveByCriteriaDAO) {
            $this->entities = $object->entities;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof RAD01PrivateIndexView) {
            $object->entities = $this->entities;
        }
    }
}
