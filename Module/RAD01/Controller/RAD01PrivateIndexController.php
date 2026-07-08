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
    protected array $rad01s = [];

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
            $this->rad01s = $object->rad01s;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof RAD01PrivateIndexView) {
            $object->rad01s = $this->rad01s;
        }
    }
}
