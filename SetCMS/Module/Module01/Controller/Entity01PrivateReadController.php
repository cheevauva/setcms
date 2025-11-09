<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveManyByCriteriaDAO;
use SetCMS\Module\Module01\View\Entity01PrivateReadView;

class Entity01PrivateReadController extends ControllerViaPSR7
{

    protected Entity01Entity $Entity01LC;
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
            $object->orThrow = true;
        }

        if ($object instanceof Entity01PrivateReadView) {
            $object->Entity01LC = $this->Entity01LC;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01RetrieveManyByCriteriaDAO) {
            $this->Entity01LC = Entity01Entity::as($object->Entity01LC);
        }
    }
}
