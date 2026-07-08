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
    protected array $rad99s = [];

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
            $this->rad99s = $object->rad99s;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof RAD99PrivateIndexView) {
            $object->rad99s = $this->rad99s;
        }
    }
}
