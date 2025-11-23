<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01RetrieveManyByCriteriaDAO;
use Module\Module01\View\Entity01PrivateReadView;
use Module\Module01\Exception\Entity01NotFoundException;

class Entity01PrivateReadController extends ControllerViaPSR7
{

    protected Entity01Entity $entity;
    protected UUID $id;

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
            Entity01PrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->throwIfEmpty = new Entity01NotFoundException();
        }

        if ($object instanceof Entity01PrivateReadView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $this->entity = $object->first();
        }
    }
}
