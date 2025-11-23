<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Servant\Entity01CreateServant;
use Module\Module01\View\Entity01PrivateCreateView;

class Entity01PrivateCreateController extends ControllerViaPSR7
{

    protected Entity01Entity $entity;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01CreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('entity')->notEmpty()->validate();

        $this->entity = new Entity01Entity();
        $this->entity->id = $validation->uuid('entity.id')->val();
        $this->entity->field01 = $validation->string('entity.field01')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01CreateServant) {
            $object->entity = $this->entity;
        }

        if ($object instanceof Entity01PrivateCreateView) {
            $object->entity = $this->entity;
        }
    }
}
