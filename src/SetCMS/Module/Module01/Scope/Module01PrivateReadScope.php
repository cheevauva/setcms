<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Contract\Twigable;
use SetCMS\UUID;
use SetCMS\Module\Module01\Entity01Entity;
use SetCMS\Module\Module01\DAO\Entity01RetrieveByIdDAO;

class Module01PrivateReadScope extends Module01PrivateScope implements Twigable
{

    protected ?Entity01Entity $entity = null;
    public UUID $id;

    public function to(object $object): void
    {
        if ($object instanceof Entity01RetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof Entity01RetrieveByIdDAO) {
            $this->entity = $object->Entity01LC;
        }
    }

    public function toArray(): array
    {
        return [
            'Entity01LC' => $this->entity,
        ];
    }

}
