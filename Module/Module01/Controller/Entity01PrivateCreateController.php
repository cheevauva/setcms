<?php

declare(strict_types=1);

namespace Module\Module01\Controller;

use SetCMS\ControllerViaPSR7;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Servant\Entity01CreateServant;
use Module\Module01\View\Entity01PrivateCreateView;

class Entity01PrivateCreateController extends ControllerViaPSR7
{

    protected Entity01Entity $Entity01LC;

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
        $validation->array('Entity01LC')->notEmpty()->validate();

        $this->Entity01LC = new Entity01Entity();
        $this->Entity01LC->id = $validation->uuid('Entity01LC.id')->val();
        $this->Entity01LC->field01 = $validation->string('Entity01LC.field01')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01CreateServant) {
            $object->Entity01LC = $this->Entity01LC;
        }

        if ($object instanceof Entity01PrivateCreateView) {
            $object->Entity01LC = $this->Entity01LC;
        }
    }
}
