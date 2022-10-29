<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity;
use SetCMS\UUID;

abstract class EntitySaveScope extends \SetCMS\Scope
{

    public UUID $id;
    protected ?Entity $entity = null;

    public function to(object $object): void
    {
        if ($object instanceof Entity) {
            $object->id = $this->id;
        }
    }

    public function toArray(): array
    {
        return [
            'entity' => $this->entity,
        ];
    }

}
