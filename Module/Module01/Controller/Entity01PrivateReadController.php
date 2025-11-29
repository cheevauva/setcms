<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01GetOneByCriteriaDAO;
use Module\Module01\View\Entity01PrivateReadView;

class Entity01PrivateReadController extends ControllerViaPSR7
{

    protected Entity01Entity $entity;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01GetOneByCriteriaDAO::class,
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

        if ($object instanceof Entity01GetOneByCriteriaDAO) {
            $object->id = $this->id;
        }

        if ($object instanceof Entity01PrivateReadView) {
            $object->entity = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01GetOneByCriteriaDAO) {
            $this->entity = $object->entity;
        }
    }
}
