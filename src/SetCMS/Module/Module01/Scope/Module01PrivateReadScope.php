<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Module\Module01\Entity\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;

class Module01PrivateReadScope extends Module01PrivateScope
{

    protected ?Entity01Entity $entity = null;

    #[Attributes('id')]
    public UUID $id;

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof Entity01RetrieveByIdDAO) {
            $object->id = $this->id;
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
