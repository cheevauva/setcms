<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Servant\Entity01GetByIdServant;
use Module\Module01\View\Entity01PrivateReadView;

class Entity01PrivateReadController extends ControllerViaPSR7
{

    protected Entity01Entity $entity01;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01GetByIdServant::class,
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

        if ($object instanceof Entity01PrivateReadView) {
            $object->entity01 = $this->entity01;
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
