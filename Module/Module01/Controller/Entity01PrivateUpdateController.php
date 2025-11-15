<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\DAO\Entity01RetrieveManyByCriteriaDAO;
use Module\Module01\Servant\Entity01UpdateServant;
use Module\Module01\View\Entity01PrivateUpdateView;

class Entity01PrivateUpdateController extends ControllerViaPSR7
{

    protected Entity01Entity $Entity01LC;
    protected Entity01Entity $newEntity01LC;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            Entity01RetrieveManyByCriteriaDAO::class,
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

        $this->newEntity01LC = new Entity01Entity;
        $this->newEntity01LC->id = $validation->uuid('Entity01LC.id')->notEmpty()->val();
        $this->newEntity01LC->field01 = $validation->string('Entity01LC.field01')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $object->id = $this->newEntity01LC->id;
            $object->orThrow = true;
        }

        if ($object instanceof Entity01UpdateServant) {
            $object->Entity01LC = $this->Entity01LC;
        }

        if ($object instanceof Entity01PrivateUpdateView) {
            $object->Entity01LC = $this->Entity01LC ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $this->Entity01LC = Entity01Entity::as($object->Entity01LC);
            $this->Entity01LC->field01 = $this->newEntity01LC->field01;
        }
    }
}
