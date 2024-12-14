<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Attribute\Http\Parameter\Body;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;
use SetCMS\Module\Module01\Servant\Entity01UpdateServant;

class Module01PrivateUpdateScope extends Module01PrivateScope
{

    protected ?Entity01Entity $entity = null;
    
    #[Body('Entity01LC')]
    public Module01PrivateEntity01Scope $Entity01LC;

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01RetrieveByIdDAO) {
            $this->entity = new Entity01Entity;
            $this->Entity01LC->to($this->entity);
            $object->id = $this->entity->id;
        }

        if ($object instanceof Entity01UpdateServant) {
            $this->Entity01LC->to($this->entity);
            $object->Entity01LC = $this->entity;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof Entity01RetrieveByIdDAO) {
            $this->entity = $object->Entity01LC;
        }
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'Entity01LC' => $this->entity,
        ];
    }
}
