<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use SetCMS\UUID;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Servant\Entity01GetByIdServant;
use Module\Module01\DAO\Entity01DeleteByIdDAO;
use Module\Module01\View\Entity01PrivateDeleteView;

class Entity01PrivateDeleteController extends ControllerViaPSR7
{

    public Entity01Entity $entity01;
    public UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01GetByIdServant::class,
            Entity01DeleteByIdDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            Entity01PrivateDeleteView::class,
        ];
    }

    #[\Override]
    protected function fromRequest(): void
    {
        $this->id = $this->validationParams()->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01GetByIdServant) {
            $object->id = $this->id;
        }

        if ($object instanceof Entity01PrivateDeleteView) {
            $object->entity01 = $this->entity01;
        }

        if ($object instanceof Entity01DeleteByIdDAO) {
            $object->id = $this->entity01->id;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01GetByIdServant) {
            $this->entity01 = $object->entity01;
        }
    }
}
