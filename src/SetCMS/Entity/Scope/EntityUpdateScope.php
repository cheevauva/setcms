<?php

declare(strict_types=1);

namespace SetCMS\Entity\Scope;

use SetCMS\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Entity\Servant\EntityUpdateServant;

abstract class EntityUpdateScope extends EntitySaveScope
{

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EntityRetrieveByIdDAO) {
            $this->entity = $object->entity;
        }
    }

    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof EntityUpdateServant) {
            $this->to($this->entity);
            $object->entity = $this->entity;
        }
        
        if ($object instanceof EntityRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

}
