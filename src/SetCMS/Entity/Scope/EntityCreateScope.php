<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity;
use SetCMS\Entity\Servant\EntityCreateServant;

abstract class EntityCreateScope extends EntitySaveScope
{

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof EntityCreateServant) {
            $this->entity = $this->entity();
            $this->to($this->entity);
            $object->entity = $this->entity;
        }
    }

    abstract protected function entity(): Entity;
}
