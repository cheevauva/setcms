<?php

declare(strict_types=1);

namespace Module\RAD99\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\RAD99\DAO\RAD99RetrieveByCriteriaDAO;
use Module\RAD99\View\RAD99PrivateIndexView;
use Module\RAD99\Entity\RAD99Entity;

class RAD99PrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var RAD99Entity[]
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            RAD99RetrieveByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            RAD99PrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RAD99RetrieveByCriteriaDAO) {
            $this->entities = $object->entities;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof RAD99PrivateIndexView) {
            $object->entities = $this->entities;
        }
    }
}
