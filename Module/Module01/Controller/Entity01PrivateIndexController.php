<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Module01\DAO\Entity01RetrieveManyByCriteriaDAO;
use Module\Module01\View\Entity01PrivateIndexView;
use Module\Module01\Entity\Entity01Entity;

class Entity01PrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var Entity01Entity[]
     */
    protected array $Entity01LCs = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01RetrieveManyByCriteriaDAO::class,
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

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $this->Entity01LCs = $object->Entity01LCs;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof Entity01PrivateIndexView) {
            $object->Entity01LCs = $this->Entity01LCs;
        }
    }
}
