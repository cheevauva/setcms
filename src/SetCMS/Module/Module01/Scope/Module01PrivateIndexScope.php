<?php

declare(strict_types=1);

namespace SetCMS\Module\Module01\Scope;

use SetCMS\Module\Module01\DAO\Entity01RetrieveManyDAO;

class Module01PrivateIndexScope extends Module01PrivateScope
{

    protected array $entities = [];

    #[\Override]
    public function from(object $object): void
    {
        if ($object instanceof Entity01RetrieveManyDAO) {
            $this->entities = $object->entities;
        }
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'entities' => $this->entities,
        ];
    }

}
