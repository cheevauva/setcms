<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\View\Entity01PrivateIndexView;
use Module\Module01\Entity\Entity01Entity;

class Entity01PrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var Entity01Entity[]
     */
    protected array $entity01s = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01RetrieveByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01RetrieveByCriteriaDAO) {
            $this->entity01s = $object->entity01s;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof Entity01PrivateIndexView) {
            $object->entity01s = $this->entity01s;
        }
    }
}
