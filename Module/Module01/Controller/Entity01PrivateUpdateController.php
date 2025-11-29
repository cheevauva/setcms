<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01GetOneByCriteriaDAO;
use Module\Module01\Servant\Entity01UpdateServant;
use Module\Module01\View\Entity01PrivateUpdateView;
use Module\Module01\Exception\Entity01EntityNotFoundException;

class Entity01PrivateUpdateController extends ControllerViaPSR7
{

    protected Entity01Entity $entity;
    protected Entity01Entity $newEntity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01GetOneByCriteriaDAO::class,
            Entity01UpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newEntity = new Entity01Entity;
        $this->newEntity->id = $validation->uuid('entity.id')->notEmpty()->val();
        $this->newEntity->field01 = $validation->string('entity.field01')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01GetOneByCriteriaDAO) {
            $object->id = $this->newEntity->id;
        }

        if ($object instanceof Entity01UpdateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof Entity01PrivateUpdateView) {
            $object->entity = $this->entity ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01GetOneByCriteriaDAO) {
            $this->entity = $object->entity;
            $this->entity->field01 = $this->newEntity->field01;
        }
    }
}
