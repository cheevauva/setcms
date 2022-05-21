<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity\Servant\EntitySaveServant;
use SetCMS\Entity;

abstract class EntitySaveScope extends \SetCMS\Scope implements \SetCMS\Contract\Applicable
{

    protected Entity $entity;

    public function to(object $object): void
    {
        if ($object instanceof EntitySaveServant) {
            $object->entity = $this->entity;
            $object->applier = $this;
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof EntitySaveServant) {
            $this->entity = $object->entity;
        }
    }

    public function toArray(): array
    {
        return [
            'entity' => $this->entity,
        ];
    }

}
