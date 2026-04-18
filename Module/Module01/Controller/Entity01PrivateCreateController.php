<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\View\Entity01PrivateCreateView;

class Entity01PrivateCreateController extends ControllerViaPSR7
{

    private Entity01Entity $entity01;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01CreateDAO::class,
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

        $this->entity01 = new Entity01Entity();
        $this->entity01->id = $validation->uuid('entity.id')->val();
        $this->entity01->field01 = $validation->string('entity.field01')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01CreateDAO) {
            $object->entity01 = $this->entity01;
        }

        if ($object instanceof Entity01PrivateCreateView) {
            $object->entity = $this->entity01;
        }
    }
}
